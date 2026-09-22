<?php if (!defined('_GNUBOARD_')) exit; ?>
<ol class="jw-register-steps" aria-label="회원가입 단계">
<?php foreach (array(1 => '약관 동의', 2 => '정보 입력', 3 => '가입 완료') as $step => $label) { ?>
    <li<?php echo $step === $jw_register_step ? ' aria-current="step"' : ''; ?>><span><?php echo $step; ?></span><?php echo $label; ?></li>
<?php } ?>
</ol>
