(function ($) {
    /**
     * Валидатор файлов
     * @param params
     * @constructor
     */

    var FileValidator = function(params) {

        this.params = {

            size: 0,
            ext: []

        }

        $.extend(this.params, params);

    }

    FileValidator.prototype.getExt = function(name) {

        var arr = name.split('.');

        var ext = arr.pop();

        return ext.toLowerCase();

    }

    FileValidator.prototype.validate = function(file) {

        return this.validateSize(file) && this.validateExt(file);

    }

    FileValidator.prototype.validateSize = function(file) {

        if(this.params.size == 0)
            return true;


        var s = this.params.size*1024*1024; // Размер в байтах

        if(file.size > s)
            return false;
        else
            return true;

    }


    FileValidator.prototype.validateExt = function(file) {

        var ext = this.getExt(file.name);

        if(this.params.ext.length == 0 || $.inArray(ext, this.params.ext)>-1)
            return true;
        else
            return false;

    }

    /**
     * Загрузчик файлов на сервер
     * @param params {files: [], fileName: 'file[]', url: '/upload.php', progressCallback: func, okCallback: func, errorCallback: func }
     * @constructor
     */

    var FileUploader = function (params) {

        this.params = params;

    }

    FileUploader.prototype.upload = function () {

        var params = this.params;

        var http = new XMLHttpRequest(); // Создаем объект XHR, через который далее скинем файлы на сервер.

        // Процесс загрузки

        if (http.upload && http.upload.addEventListener) {


            if (params.progressCallback) {

                http.upload.addEventListener( // Создаем обработчик события в процессе загрузки.
                    'progress',
                    params.progressCallback,
                    false
                );

            }

            http.onreadystatechange = function () {

                if (this.readyState == 4) {

                    if (this.status == 200) {

                        if (params.okCallback)
                            params.okCallback.apply(this);

                    } else {
                        if (params.errorCallback)
                            params.errorCallback.apply(this);
                    }

                }
            };

            http.upload.addEventListener(
                'error',
                function (e) {
                    alert("Ошибка при загрузке файла");
                });
        }

        var form = new FormData(); // Создаем объект формы.

        form.append('path', '/'); // Определяем корневой путь.

        for (var i = 0; i < this.params.files.length; i++) {
            form.append(this.params.fileName, this.params.files[i]); // Прикрепляем к форме все загружаемые файлы.
        }

        http.open('POST', this.params.url); // Открываем коннект до сервера.

        http.send(form); // И отправляем форму, в которой наши файлы. Через XHR.


    }


    /**
     * Виджет html5 загрузки файлов
     * @param input jQuery обертка инпута с файлом
     * @param params объект параметров {uploadUrl: '/upload.php', maxFileSize: 2, allowedExt: ["jpg", "jpeg", "gif"]}
     */


    var UploaderWidget = function (input, params) {

        this.params = {

            uploadUrl: '/upload.php',
            maxFileSize: 2, // МБ
            allowedExt: ["jpg", "jpeg", "gif", "png", "pdf", "doc", "docx", "xsl", "xslx", "odt", "ppt", "zip", "rar", "gz", "tar", "swf", "csv"]

        }

        $.extend(this.params, params);

        this.input = input;

        this.form = input.parents('form');

        if (this.form.length == 0)
            throw new Error('Виджет должен находится в форме');

        var formElem = this.form.get(0);

        if(!formElem.uploadQueue)
            formElem.uploadQueue = {}; // Очередь загрузки

        if(!formElem.uploadValidators)
            formElem.uploadValidators = {}; // Валидаторы файлов для каждой очереди

        this.inputName = this.input.attr("name");

        formElem.uploadQueue[this.inputName] = [];

        formElem.uploadValidators[this.inputName] = new FileValidator({

            size: this.params.maxFileSize,
            ext: this.params.allowedExt

        });

        this.input.removeAttr("name");

        this.dropBox = input.next('.uploader-widget-drop-box');

        this.filesList = this.dropBox.find(".uploader-widget-files-list");

        this.bindEvents();

    }

    UploaderWidget.prototype.submitForm = function(form) {

        if(!this.hasInQueue(form)) {
            console.log(form);
            $(form).find("[type='submit']").attr("disabled", false);
            $(form).submit();
        }

    }

    UploaderWidget.prototype.hasInQueue = function(form) {

        for(var k in form.uploadQueue) {

            if(form.uploadQueue[k].length > 0)
                return true;

        }

        return false;

    }

    UploaderWidget.prototype.validateFiles = function(form) {

        for(var k in form.uploadQueue) {

            var validator = form.uploadValidators[k];

            var queue = form.uploadQueue[k];

            for (var i = 0; i < queue.length; i++) {

                var li = queue[i];

                var file = li.get(0).file

                if(!validator.validateExt(file)) {

                    alert("Недопустипый тип файла "+file.name);
                    return false;

                }

                if(!validator.validateSize(file)) {

                    alert("Недопустипый размер файла "+file.name);
                    return false;

                }

            }

        }

        return true;

    }

    UploaderWidget.prototype.bindEvents = function () {

        var self = this;

        // Добавление файлов при выборе через Input

        this.input.bind({
            change: function () {
                self.addFiles(this.files);
            }
        });

        // Добавление файлов drag and drop

        this.dropBox.on({
            dragenter: function () {
                $(this).addClass('uploader-widget-highlighted');
                return false;
            },
            dragover: function () {
                return false;
            },
            dragleave: function () {
                $(this).removeClass('uploader-widget-highlighted');
                return false;
            },
            drop: function (e) {
                var dt = e.originalEvent.dataTransfer;
                self.addFiles(dt.files);
                return false;
            }
        });

        var submit = this.form.find("[type='submit']");

        submit.off('click');

        submit.on('click', function(){

            var form = $(this).parents('form');

            if(self.hasInQueue(form[0])) {

                if( self.validateFiles(form[0]))
                    form.trigger('uploader.submit');

                return false;

            }

            return true;

        });

        // Загрузка файлов перед отправкой формы

        this.form.on('uploader.submit', function (e) {

            var formSelf = this;

            var uploadedFiles = 0;

            var length = this.uploadQueue[self.inputName].length;

            if(length>0)
                $(this).find("[type='submit']").attr("disabled", true); // Делаем неактивными кнопки отправки

            // Загрузка

            for (var i = 0; i < length; i++) {

                (function (i) {

                    var li = formSelf.uploadQueue[self.inputName][i];

                    var file = li.get(0).file

                    var files = [file];

                    var uploader = new FileUploader({

                        url: self.params.uploadUrl,

                        files: files,

                        fileName: self.inputName+'[]',

                        progressCallback: function (e) {
                            if (e.lengthComputable) {

                                var progress = Math.round(e.loaded / e.total * 100);

                                li.find('.uploader-widget-progress').width(progress + '%');

                            }
                        },

                        okCallback: function(){

                            li.find('.uploader-file-name').val(this.responseText);

                            uploadedFiles++;

                            self.removeFromQueue(li.get(0));

                            if(uploadedFiles == length) { // Все файлы загруженвы, отправляем форму
                                self.submitForm(formSelf);
                            }

                        },

                        errorCallback: function() {

                            alert(this.responseText);

                            $(formSelf).find("[type='submit']").attr("disabled", false);

                        }

                    });

                    uploader.upload();
                })(i);

            }

            return false;

        });

        // Удалние файлов

        $('body').on('click', '.uploader-file-remove', function(e) {

            var li = $(this).parents('li');

            var ul = $(this).parents('ul');

            self.removeFromQueue(li.get(0));

            li.remove();

            if(ul.find('li').length==0) {

                self.input.prev().val("");

            }

            e.preventDefault();

        });


    }

    UploaderWidget.prototype.removeFromQueue = function(elem) {

        var q = this.form.get(0).uploadQueue[this.inputName];

        for(var k in q) {
            if(q[k].get(0) == elem)
                q.splice(k,1);

        }

    }

    // Добавление файлов

    UploaderWidget.prototype.addFiles = function (files) {

        var self = this;

        $.each(files, function (i, file) {

            var li = $('<li/>').appendTo(self.filesList);

            self.form.get(0).uploadQueue[self.inputName].push(li); // Добавляем файл в единую очередь

            var i = li.index();

            li.get(0).file = file;

            $('<div class="uploader-widget-name"></div>').text(file.name).appendTo(li);

            var previewPlace =  $('<div class="uploader-widget-preview"></div>').appendTo(li);

            if (file.type.match(/image.*/)) {

                var img = $('<img/>').appendTo(previewPlace);

                var reader = new FileReader();

                reader.onload = (function (aImg) {

                    return function (e) {
                        aImg.attr('src', e.target.result);
                        aImg.attr('width', 150);
                    };

                })(img);

                reader.readAsDataURL(file);

            }

            $('<div/>').addClass('uploader-widget-progress progress-bar').appendTo(li);

            var fileName = self.inputName + "[" + i + "][file]";

            var titleName = self.inputName + "[" + i + "][title]";

            $('<input type="hidden" name="' + fileName + '" value="" class="uploader-file-name" />').appendTo(li);

            $('<input type="text" name="' + titleName + '" value="" class="uploader-file-title" />').appendTo(li);

            $('<div><a href="#" class="uploader-file-remove">удалить</a></div>').appendTo(li);

        });

        if(files.length>0) {

            this.input.prev().val(1);

        }


    }


    $.fn.html5Uploader = function (params) {

        return this.each(function () {

            var uploader = new UploaderWidget($(this), params);

            this.uploaderWidget = uploader;


        });


    }


})(jQuery);
