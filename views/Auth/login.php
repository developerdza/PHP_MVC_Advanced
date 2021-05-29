<?php $form = app\core\Form\Form::begin("" , "post");

?>

        <div class="form-group">
            <legend>Form title</legend>
        </div>

<div class="input-group ">
    <div class="input-group-addon row m-3"> <?php  echo $form->field($model , 'email');?> </div>
  </div>
   <span class="label label-danger col  m-3"> <?php   echo $model->getError('email');?></span>
<div class="input-group">
<div class="input-group-addon" ><?php  echo $form->field($model , "password")->password_field();?></div> 
</div>
<span class="label label-danger col  m-3"> <?php   echo $model->getError('password');?></span>

        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        <?php   app\core\Form\Form::end();?>
