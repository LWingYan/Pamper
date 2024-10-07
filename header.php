<meta charset="utf-8" />
<meta name="renderer" content="webkit" />
<meta name="format-detection" content="email=no" />
<meta name="format-detection" content="telephone=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, shrink-to-fit=no, viewport-fit=cover">
<link rel="shortcut icon" href="<?php $this->options->JFavicon() ?>" />
<title><?php $this->archiveTitle(array('category' => '分类 %s 下的文章', 'search' => '包含关键字 %s 的文章', 'tag' => '标签 %s 下的文章', 'author' => '%s 发布的文章'), '', ' - '); ?><?php $this->options->title(); ?></title>
<?php if ($this->is('single')) : ?>
  <meta name="keywords" content="<?php echo $this->fields->keywords ? $this->fields->keywords : htmlspecialchars($this->_keywords); ?>" />
  <meta name="description" content="<?php echo $this->fields->description ? $this->fields->description : htmlspecialchars($this->_description); ?>" />
  <?php $this->header('keywords=&description='); ?>
<?php else : ?>
  <?php $this->header(); ?>
<?php endif; ?>
<script>
  window.Pamper = {
    SiteUrl_URL:`<?php $this->options->siteUrl(); ?>`;
    THEME_URL: `<?php Helper::options()->themeUrl() ?>`,
    // 其他配置项...
    };
</script>
<?php
    $fontUrl = $this->options->CustomFont ?? ''; // 使用空字符串作为默认值
    $fontFormat = '';
    
    if (strpos($fontUrl, 'woff2') !== false) {
        $fontFormat = 'woff2';
    } elseif (strpos($fontUrl, 'woff') !== false) {
        $fontFormat = 'woff';
    } elseif (strpos($fontUrl, 'ttf') !== false) {
        $fontFormat = 'truetype';
    } elseif (strpos($fontUrl, 'eot') !== false) {
        $fontFormat = 'embedded-opentype';
    } elseif (strpos($fontUrl, 'svg') !== false) {
        $fontFormat = 'svg';
    }
    
?>
<style>
  @font-face {
    font-family: 'Pamper Font';
    font-weight: 400;
    font-style: normal;
    font-display: swap;
    src: url('<?php echo $fontUrl ?>');
    <?php if ($fontFormat) : ?>src: url('<?php echo $fontUrl ?>') format('<?php echo $fontFormat ?>');
    <?php endif; ?>
  }
  @font-face{
    font-family: 'zql Font';
    src:  url('//jsd.cdn.zzko.cn/gh/LWingYan/photos@latest/zql.woff');
    src:  url('//jsd.cdn.zzko.cn/gh/LWingYan/photos@latest/zql.woff2');
    }
    
  body {
    <?php if ($fontUrl) : ?>font-family: 'Pamper Font';
    <?php else : ?>font-family: 'zql Font','Helvetica Neue', Helvetica, 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei', '微软雅黑', Arial, sans-serif;
    <?php endif; ?>
  }
  <?php $this->options->CustomCSS() ?>
</style>
<?php if ($this->options->Favicon()) : ?>
<link rel="shortcut icon" href="<?php $this->options->Favicon() ?>" />
<?php else : ?>
<link rel="shortcut icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text x=%22-0.125em%22 y=%22.9em%22 font-size=%2290%22>💤</text></svg>" />
<?php endif; ?>
<!-- 提示 -->
<link href="<?php _getAssets('assets/message.css'); ?>" rel="stylesheet" />
<!-- 全局 -->
<link href="<?php _getAssets('assets/style.css'); ?>" rel="stylesheet" />
<!-- 音乐 -->
<link href="<?php _getAssets('assets/muisc.css'); ?>" rel="stylesheet" />
<!-- icon -->
<link href="https://jsd.onmicrosoft.cn/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
<!-- 代码块 -->
<?php if ($this->options->PrismTheme) : ?>
<link href="<?php $this->options->PrismTheme() ?>" rel="stylesheet">
<?php else : ?>
<link href="//npm.elemecdn.com/prismjs@1.29.0/themes/prism.min.css" rel="stylesheet">
<?php endif; ?>
<?php $this->options->CustomHeadEnd() ?>
<div class="container-sm mx-auto my-4" style="padding:.7rem;">
    <div class="relative z-8 flex justify-between items-center mb-3.5">
        <div class="border-solid border-2 border-black rounded-2xl bg-blue-300 p-2" style="width:45px;height:45px;text-align: center;" id="toggle-nav">
            <i class="ri-bubble-chart-line text-yellow-500 leading-none text-2xl"></i>
        </div>
        <div class="text-xl night:text-gray-100 pjax">
            <?php if ($this->is('index')) : ?>
            <h6>Home</h6>
            <?php endif; ?>
            
            <?php if ($this->is('page')) :  //判断独立页面page ?>
            <h6>Page</h6>
            <?php endif; ?>
            
            <?php if ($this->is('post')) : //判断文章页面post ?>
            <h6>Post</h6>
            <?php endif; ?>
            
            <?php if ($this->is('category')) ://判断分类页面 ?>
            <h6>Category</h6>
            <?php endif; ?>
            <?php if ($this->is('tag')) ://判断标签页面 ?>
            <h6>Tag</h6>
            <?php endif; ?>
        </div>
        <div class="flex gap-2 items-center">
            <i class="ri-lg ri-notification-4-line transition rotate-10" id="toggle-notification"></i>
            <img src="<?php $this->options->作者头像() ?>" width="45" height="45" class="transition translatey-4 shadow border-3 rounded-2xl border-solid border-white">
        </div>
    </div>


