<?php
use framework\helpers\Html;
use framework\security\Csrf;
use framework\captcha\Captcha;
$this->title .= ' - ورود';
$captcha = new Captcha();
$captchaQuestion = $captcha->createQuestion();
?>
<form method="POST">
<?php echo Html::hiddenField('csrf', ['value' => Csrf::generate()], false); ?>
<div class="container">
    <div class="col-md-4 col-md-offset-4">
        <div class="main-box login">
            <div class="main-box-inner">
                <hgroup><h3><span class="glyphicon glyphicon-log-in"></span> ورود به مدیریت</h3></hgroup>
                <div class="login-img"><center><img src="<?php echo $this->getThemeUrl('img/avatar.png'); ?>" class="img-responsive"></center></div>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <?php echo Html::textField('userName', ['class' => 'form-control', 'placeholder' => 'نام کاربری']); ?>
                </div>
                <?php echo $model->getMessage('userName'); ?>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <?php echo Html::passwordField('password', ['class' => 'form-control', 'placeholder' => 'کلمه عبور']); ?>
                </div>
                <?php echo $model->getMessage('password'); ?>
                <div class="form-group" style="overflow:hidden;margin-top:12px;">
                    <label for="captcha" style="display:block;margin-bottom:6px;">حاصل عبارت زیر را وارد کنید: <strong dir="ltr"><?php echo htmlspecialchars($captchaQuestion, ENT_QUOTES, 'UTF-8'); ?></strong></label>
                    <?php echo Html::textField('captcha', ['id' => 'captcha', 'class' => 'form-control', 'placeholder' => 'پاسخ محاسبه', 'autocomplete' => 'off', 'inputmode' => 'numeric'], false); ?>
                </div>
                <?php echo $model->getMessage('captcha'); ?>
                <div class="main-box-footer">
                    <div class="form-group">
                        <button class="btn my-btn"><span class="glyphicon glyphicon-chevron-left"></span> ورود</button>
                    </div>
                </div>
                <?php foreach (framework\session\Session::instance()->getFlashes() as $key => $message) { ?>
                    <div class="alert alert-<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</form>