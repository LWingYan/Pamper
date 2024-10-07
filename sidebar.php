<!-- 导航 -->
<nav class="fixed z-9 top bottom p-2 bg-blue-500 border-solid border-2 border-black nav-active" style="border-radius:0 1rem 1rem 0;left:-300;transition: left .3s ease-out;width:300px;">
    <div class="flex flex-col h-full justify-between">
        <div class="overflow">
            <h6>组件</h6>
            <div class="flex flex-col gap-2" style="padding: 10px 0 10px 20px;">
                <a class="p-2 text-base relative z-1 night:text-gray-100 <?php if($this->is('index')): ?> active <?php endif; ?>" href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a>
                <?php $this->widget('Widget_Metas_Category_List')->to($category); ?>
                <?php while($category->next()): ?>
                <a class="p-3 text-base relative z-1 night:text-gray-100 <?php echo isActiveMenu($this,$category->slug); ?>" href="<?php $category->permalink(); ?>" title="<?php $category->name(); ?>"><?php $category->name(); ?></a>
                <?php endwhile; ?>
            </div>
            <h6>配件</h6>
                
            <div class="flex flex-col gap-2" style="padding: 10px 0 10px 20px;">
            <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
            <?php while($pages->next()): ?>
            <a class="p-3 text-base relative z-1 night:text-gray-100 <?php if($this->is('page', $pages->slug)): ?> active <?php endif; ?>"  href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
            <?php endwhile; ?>
            </div>
        </div>
        
        <div>
            <center class="text-xs">&copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a></center>
        </div>
    </div>
</nav>