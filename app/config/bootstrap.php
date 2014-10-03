<?php
\Yii::$container->set(\yii\widgets\Pjax::className(), ["timeout" => false]);
\Yii::$container->set(\mcms\xeditable\XEditableAsset::className(), ["publishOptions" => ['forceCopy' => false]]);
\Yii::$container->set(\yii\jui\DatePicker::className(), ['language' => "ru", "dateFormat" => "yyyy-MM-dd"]);
\Yii::$container->set(\mcms\xeditable\XEditableColumn::className(), ['editable'=>null]);
