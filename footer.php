    <!-- 底部 -->
    <footer class="my-2 text-base night:text-gray-100">
        <?php $this->options->Footer() ?>
    </footer>
    
    <div class="mt-8 sticky" style="bottom:10px;">
            <!-- 音乐 -->
            <div class="music-active relative" style="height:0px;">
                <div class="absolute bottom-control" style="
                background-color: var(--c-gray-100);
                border-radius: 20px;
                border: 2px solid var(--c-gray-900);
                width: 95%;
                left: calc(50% - 47.5%);
                height: 100%;
                bottom: -40px;
                padding: 10px 10px 20px 10px;
                transition: bottom 0.3s ease-out 0s;
                ">
                    <div id="nav-music" class="music" style="opacity:0;">
                    	<a id="nav-music-hoverTips" onclick="Pamper_music.musicToggle()" accesskey="m" draggable="false">播放音乐</a>
                    </div>
                </div>
            </div>
                
            
            <style>
                
            </style>
            <div class="z-8">
                <div class="gap-2 relative menu-inner flex border-solid border-2 border-black rounded-2xl w-full justify-between p-3 bg-blue-500 " style="height: 90px;">
                    <a style="width:80px;padding-top: 0.375rem;padding-bottom: 0.375rem;" class="transition hover:active flex justify-content items-center text-2xl rounded-2xl font-bold <?php if($this->is('index')): ?> active border-gray-900 border-solid text-gray-900 bg-yellow-500 <?php endif; ?> " href="<?php $this->options->siteUrl(); ?>">
                        <i class="ri-home-line"></i>
                    </a>
                    <a style="width:80px;padding-top: 0.375rem;padding-bottom: 0.375rem;" class="transition hover:active flex justify-content items-center text-2xl rounded-2xl font-bold" id="toggle-music">
                        <i class="ri-headphone-line"></i>
                    </a>
                    <a style="width:80px;padding-top: 0.375rem;padding-bottom: 0.375rem;" class="transition hover:active flex justify-content items-center text-2xl rounded-2xl font-bold " id="toggle-night-mode">
                        <i class="ri-contrast-2-line"></i>
                    </a>
                    <a style="width:80px;padding-top: 0.375rem;padding-bottom: 0.375rem;" class="transition hover:active flex justify-content items-center text-2xl rounded-2xl font-bold " id="back-to-top">
                        <i class="ri-rocket-line"></i>
                    </a>
                    
                </div>
            </div>
        </div>
        
    
</div>
<!-- container -->
<?php $this->need('sidebar.php'); ?>

    <!-- 全靠jquery -->
    <script src="<?php _getAssets('assets/js/jquery.min.js'); ?>"></script>
    <!-- cookie -->
    <script src="<?php _getAssets('assets/js/js.cookie.min.js'); ?>"></script>
    <!-- 弹出提示 -->
    <script src="<?php _getAssets('assets/js/message.js'); ?>"></script>
    <!-- 灯箱 -->
    <script src="<?php _getAssets('assets/js/view-image.min.js'); ?>"></script>
    <!-- 懒加载 -->
    <script src="<?php _getAssets('assets/js/lazysizes.js'); ?>"></script>
    <!-- 配置灯箱 -->
    <script>
        window.ViewImage && ViewImage.init('.post-content img , .comment-content img , .commentText img' );
    </script>
    <!-- 音乐 -->
    <script src="<?php _getAssets('assets/js/APlayer.js'); ?>"></script>
    <script src="<?php _getAssets('assets/js/meting.js'); ?>"></script>
    <script src="<?php _getAssets('assets/js/Meting2.min.js'); ?>"></script>
    <script>
        $(function () {
            var metingJsElement = $('<meting-js></meting-js>').attr({
                id: '<?php echo $this->options->id(); ?>',
                server: '<?php echo $this->options->server(); ?>',
                type: 'playlist',
                mutex: 'true',
                preload: 'auto',
                'list-folded': 'true' // 注意：这里使用了短横线来匹配可能的HTML属性或自定义属性
            });
        
            // 将<meting-js>元素添加到具有id="nav-music"的元素中
            $('#nav-music').append(metingJsElement);
        
        });
    </script>
    <!-- 访客优化 -->
    <script src="//instant.page/5.2.0" type="module" integrity="sha384-jnZyxPjiipYXnSU0ygqeac2q7CVYMbh84q0uHVRRxEtvFPiQYbXWUorga2aqZJ0z"></script>
    <!-- 代码块 -->
    <script src="//testingcf.jsdelivr.net/gh/LWingYan/public@latest/prism.min.js"></script>
    <!-- pjax -->
    <script src="<?php _getAssets('assets/js/pjax.js'); ?>"></script>
    <!-- 全局 -->
    <script src="<?php _getAssets('assets/js/script.js'); ?>"></script>
    
    <script>
      <?php $this->options->CustomScript() ?>
    </script>
    
    <?php $this->options->CustomBodyEnd() ?>
    
<?php $this->footer(); ?>