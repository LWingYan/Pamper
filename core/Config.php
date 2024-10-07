<?php
$GLOBALS['config'] = require_once "config.inc.php";
function CheckSetBack() {
		$db = Typecho_Db::get();
		$res = $db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:' . $GLOBALS['config']['theme'] . 'bf'));
		if ($res) {
			return '<span style="color: #1462ff">模板已备份</span>';
		} else {
			return '<span style="color: red">未备份任何数据</span>';
		}
}
class EchoHtml extends Typecho_Widget_Helper_Layout {
	public function __construct($html) {
		$this->html($html);
		$this->start();
		$this->end();
	}
	public function start() {
	}
	public function end() {
	}
}
//主题静态资源的绝对地址
function themeConfig($form)
{
    ?>
    <link rel="stylesheet" href="<?php _getAssets('assets/typecho/config.css'); ?>">
    <script src="<?php _getAssets('assets/typecho/config.js'); ?>"></script>
    <?php 
    //侧边导航
    $form->addItem(new EchoHtml('<div class="flex allTab"><div class="tab sticky h-fit top-0">'));
        $form->addItem(new EchoHtml('<div class="before:border-b my-15 word-keep w-f fz-15 align-left tabLinks relative">基础设置</div>'));
        $form->addItem(new EchoHtml('<div class="before:border-b my-15 word-keep w-f fz-15 align-left tabLinks relative">首页设置</div>'));
        $form->addItem(new EchoHtml('<div class="before:border-b my-15 word-keep w-f fz-15 align-left tabLinks relative">底部设置</div>'));
        $form->addItem(new EchoHtml('<div class="before:border-b my-15 word-keep w-f fz-15 align-left tabLinks relative">开发设置</div>'));
        $form->addItem(new EchoHtml('<div class="before:border-b my-15 word-keep w-f fz-15 align-left tabLinks relative">邮箱设置</div>'));
        $form->addItem(new EchoHtml('<div class="before:border-b my-15 word-keep w-f fz-15 align-left tabLinks relative">更多设置</div>'));
        $form->addItem(new EchoHtml('</div>'));
        //基础设置
        $form->addItem(new EchoHtml('<div class="none h-auto tabContent w-f px-30">'));
        
            //站标设置
            $Favicon = new Typecho_Widget_Helper_Form_Element_Text('Favicon', NULL, NULL, _t('博客ICO'), _t('请输入博客ICO地址'));
            $form->addInput($Favicon);
            
            //作者头像
            $作者头像 = new Typecho_Widget_Helper_Form_Element_Text('作者头像', NULL, 'https://q1.qlogo.cn/g?b=qq&nk=160860446&s=100', _t('自定义作者头像链接'), _t('填写作者头像链接'));
            $form->addInput($作者头像);
            
            //静态资源
            $AssetsURL = new Typecho_Widget_Helper_Form_Element_Text(
                'AssetsURL',
                NULL,
                NULL,
                '自定义静态资源CDN地址（非必填）',
                '介绍：自定义静态资源CDN地址，不填则走本地资源 <br />
                 教程：<br />
                 1. 将整个assets目录上传至你的CDN <br />
                 2. 填写静态资源地址访问的前缀 <br />
                 3. 例如：https://npm.elemecdn.com/typecho'
            );
            $form->addInput($AssetsURL);
  
            // 自定义头像源
            $CustomAvatarSource = new Typecho_Widget_Helper_Form_Element_Text(
            'CustomAvatarSource',
            NULL,
            NULL,
            '自定义头像源（非必填）',
            '介绍：用于修改全站头像源地址 <br>
                 例如：https://gravatar.ihuan.me/avatar/ <br>
                 其他：非必填，默认头像源为https://gravatar.helingqi.com/wavatar/ <br>
                 注意：填写时，务必保证最后有一个/字符，否则不起作用！'
          );
          $form->addInput($CustomAvatarSource);
  
        $form->addItem(new EchoHtml('</div>'));
    
        //首页设置
        $form->addItem(new EchoHtml('<div class="none h-auto tabContent w-f px-30">'));
        
            $form->addItem(new EchoHtml('<h3>这一块暂未添加</h3>'));
            
            // 推荐文章
            $Index_Recommend = new Typecho_Widget_Helper_Form_Element_Text(
                'Index_Recommend',
                NULL,
                NULL,
                '首页推荐文章（非必填）',
                '介绍：用于显示推荐文章，请务必填写正确的格式 <br/>
                     格式：文章的id || 文章的id （中间使用两个竖杠分隔）<br />
                     例如：1 || 2 <br />
                     注意：如果填写的不是2个，将不会显示'
            );
            $form->addInput($Index_Recommend);
            
        $form->addItem(new EchoHtml('</div>'));
        
        //底部设置
        $form->addItem(new EchoHtml('<div class="none h-auto tabContent w-f px-30">'));
        
            // 增加底部内容
            $Footer = new  Typecho_Widget_Helper_Form_Element_Textarea('Footer', NULL, NULL, _t('自定义增加底部内容（非必填）'), _t('可以添加备案或者统计代码等可以使用HTML来实现！！！'));
            $form->addInput($Footer);
            
        $form->addItem(new EchoHtml('</div>'));
        
        // 开发设置
        $form->addItem(new EchoHtml('<div class="none h-auto tabContent w-f px-30">'));
        
            // 自定义CSS
            $CustomCSS = new  Typecho_Widget_Helper_Form_Element_Textarea('CustomCSS', NULL, NULL, _t('自定义CSS（非必填）'), _t('请填写自定义CSS内容，填写时无需填写style标签！！！'));
            $form->addInput($CustomCSS);
            
            // 增加css链接
            $CustomHeadEnd = new  Typecho_Widget_Helper_Form_Element_Textarea('CustomHeadEnd', NULL, NULL, _t('自定义增加&lt;head&gt;&lt;/head&gt;里内容（非必填）'), _t('此处用于在&lt;head&gt;&lt;/head&gt;标签里增加自定义内容！！！'));
            $form->addInput($CustomHeadEnd);
            
            // 自定义js
            $CustomScript = new Typecho_Widget_Helper_Form_Element_Textarea(
            'CustomScript',
            NULL,
            NULL,
            '自定义JS（非必填）',
            '介绍：请填写自定义JS内容，例如网站统计等，填写时无需填写script标签。'
          );
          $form->addInput($CustomScript);
 
            // 增加js链接
            $CustomBodyEnd = new Typecho_Widget_Helper_Form_Element_Textarea(
            'CustomBodyEnd',
            NULL,
            NULL,
            '自定义&lt;body&gt;&lt;/body&gt;末尾位置内容（非必填）',
            '介绍：此处用于填写在&lt;body&gt;&lt;/body&gt;标签末尾位置的内容 <br>
                 例如：可以填写引入第三方js脚本等等'
          );
          $form->addInput($CustomBodyEnd);
            
        $form->addItem(new EchoHtml('</div>'));
        
        // 邮箱设置
        $form->addItem(new EchoHtml('<div class="none h-auto tabContent w-f px-30">'));
            // 邮件通知
            $JCommentMail = new Typecho_Widget_Helper_Form_Element_Select('JCommentMail', array('off' => '关闭（默认）', 'on' => '开启'), 'off', '是否开启评论邮件通知', '介绍：开启后评论内容将会进行邮箱通知 <br />
                 注意：此项需要您完整无错的填写下方的邮箱设置！！ <br />
                 其他：下方例子以QQ邮箱为例，推荐使用QQ邮箱');
            $form->addInput($JCommentMail->multiMode());
            // 邮箱服务器地址
            $JCommentMailHost = new Typecho_Widget_Helper_Form_Element_Text('JCommentMailHost', NULL, NULL, '邮箱服务器地址', '例如：smtp.qq.com');
            $form->addInput($JCommentMailHost->multiMode());
            $JCommentSMTPSecure = new Typecho_Widget_Helper_Form_Element_Select('JCommentSMTPSecure', array('ssl' => 'ssl（默认）', 'tsl' => 'tsl'), 'ssl', '加密方式', '介绍：用于选择登录鉴权加密方式');
            $form->addInput($JCommentSMTPSecure->multiMode());
            $JCommentMailPort = new Typecho_Widget_Helper_Form_Element_Text('JCommentMailPort', NULL, NULL, '邮箱服务器端口号', '例如：465');
            $form->addInput($JCommentMailPort->multiMode());
            $JCommentMailFromName = new Typecho_Widget_Helper_Form_Element_Text('JCommentMailFromName', NULL, NULL, '发件人昵称', '例如：帅气的象拔蚌');
            $form->addInput($JCommentMailFromName->multiMode());
            $JCommentMailAccount = new Typecho_Widget_Helper_Form_Element_Text('JCommentMailAccount', NULL, NULL, '发件人邮箱', '例如：2323333339@qq.com');
            $form->addInput($JCommentMailAccount->multiMode());
            $JCommentMailPassword = new Typecho_Widget_Helper_Form_Element_Text('JCommentMailPassword', NULL, NULL, '邮箱授权码', '介绍：这里填写的是邮箱生成的授权码 <br>
                 获取方式（以QQ邮箱为例）：<br>
                 QQ邮箱 > 设置 > 账户 > IMAP/SMTP服务 > 开启 <br>
                 其他：这个可以百度一下开启教程，有图文教程');
            $form->addInput($JCommentMailPassword->multiMode());
            
        $form->addItem(new EchoHtml('</div>'));
        // 更多设置
        $form->addItem(new EchoHtml('<div class="none h-auto tabContent w-f px-30">'));
            // 代码块
            $PrismTheme = new Typecho_Widget_Helper_Form_Element_Select(
            'PrismTheme',
            array(
              '//npm.elemecdn.com/prismjs@1.29.0/themes/prism.min.css' => 'prism（默认）',
              '//npm.elemecdn.com/prismjs@1.29.0/themes/prism-dark.min.css' => 'prism-dark',
              '//npm.elemecdn.com/prismjs@1.29.0/themes/prism-okaidia.min.css' => 'prism-okaidia',
              '//npm.elemecdn.com/prismjs@1.29.0/themes/prism-solarizedlight.min.css' => 'prism-solarizedlight',
              '//npm.elemecdn.com/prismjs@1.29.0/themes/prism-tomorrow.min.css' => 'prism-tomorrow',
              '//npm.elemecdn.com/prismjs@1.29.0/themes/prism-twilight.min.css' => 'prism-twilight',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-a11y-dark.min.css' => 'prism-a11y-dark',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-atom-dark.min.css' => 'prism-atom-dark',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-base16-ateliersulphurpool.light.min.css' => 'prism-base16-ateliersulphurpool.light',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-cb.min.css' => 'prism-cb',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-coldark-cold.min.css' => 'prism-coldark-cold',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-coldark-dark.min.css' => 'prism-coldark-dark',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-darcula.min.css' => 'prism-darcula',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-dracula.min.css' => 'prism-dracula',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-duotone-dark.min.css' => 'prism-duotone-dark',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-duotone-earth.min.css' => 'prism-duotone-earth',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-duotone-forest.min.css' => 'prism-duotone-forest',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-duotone-light.min.css' => 'prism-duotone-light',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-duotone-sea.min.css' => 'prism-duotone-sea',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-duotone-space.min.css' => 'prism-duotone-space',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-ghcolors.min.css' => 'prism-ghcolors',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-gruvbox-dark.min.css' => 'prism-gruvbox-dark',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-hopscotch.min.css' => 'prism-hopscotch',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-lucario.min.css' => 'prism-lucario',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-material-dark.min.css' => 'prism-material-dark',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-material-light.min.css' => 'prism-material-light',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-material-oceanic.min.css' => 'prism-material-oceanic',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-night-owl.min.css' => 'prism-night-owl',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-nord.min.css' => 'prism-nord',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-pojoaque.min.css' => 'prism-pojoaque',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-shades-of-purple.min.css' => 'prism-shades-of-purple',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-synthwave84.min.css' => 'prism-synthwave84',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-vs.min.css' => 'prism-vs',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-vsc-dark-plus.min.css' => 'prism-vsc-dark-plus',
              '//npm.elemecdn.com/prism-themes@1.9.0/themes/prism-xonokai.min.css' => 'prism-xonokai',
              '//npm.elemecdn.com/prism-theme-one-light-dark@1.0.4/prism-onelight.min.css' => 'prism-onelight',
              '//npm.elemecdn.com/prism-theme-one-light-dark@1.0.4/prism-onedark.min.css' => 'prism-onedark',
              '//npm.elemecdn.com/prism-theme-one-dark@1.0.0/prism-onedark.min.css' => 'prism-onedark2',
            ),
            '//npm.elemecdn.com/prismjs@1.29.0/themes/prism.min.css',
            '选择一款您喜欢的代码高亮样式',
            '介绍：用于修改代码块的高亮风格 <br>
                 其他：如果您有其他样式，可通过源代码修改此项，引入您的自定义样式链接'
          );
            $form->addInput($PrismTheme->multiMode());
            // 字体设置
            $CustomFont = new Typecho_Widget_Helper_Form_Element_Text('CustomFont', NULL, NULL, _t('自定义网站字体（非必填）'), _t('字体URL链接（推荐使用woff格式的字体，网页专用字体格式），字体文件一般有几兆，建议使用cdn链接！！！'));
            $form->addInput($CustomFont);
            
            $form->addItem(new EchoHtml('<h3>音乐设置</h3>'));
            
            // 音乐
            $server = new Typecho_Widget_Helper_Form_Element_Radio('server', ['tencent' => 'QQ音乐', 'netease' => '网易云音乐', 'kugou' => '酷狗', 'baidu' => '百度音乐'], 'netease', _t('服务平台'));
            $form->addInput($server);
        
            $id = new Typecho_Widget_Helper_Form_Element_Text('id', NULL, '98317854', _t('歌单ID'));
            $form->addInput($id);
            
            
        $form->addItem(new EchoHtml('</div>'));
        
        
        
    //结束
    $form->addItem(new EchoHtml('</div>'));
    
}