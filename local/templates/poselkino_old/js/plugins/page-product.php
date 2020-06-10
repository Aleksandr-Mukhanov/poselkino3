<?php
   /*
   Template Name: Product
   */
   
   ?>
<?php get_header(); ?>
<?php get_template_part('bread'); ?>



<!-- social links from customizer -->
<?php 
$social_links = array(
    array('fb_link', 'fa-facebook'),
    array('tw_link', 'fa-twitter'),
    array('linked_link', 'fa-instagram'),
);

$social_links_html ='<div class="social-floating-block">';

foreach ($social_links as $link) {
    if (get_theme_mod($link[0])) {
        $social_links_html .= '<a href="'.get_theme_mod($link[0]).'" target = "_blank" rel="nofollow"><i class="fa '.$link[1].'"></i></a>';
    }
}
$social_links_html .= '</div>';
?>

<?php echo $social_links_html; ?>






<!--begin product top-->
<?php while ( have_posts() ) : the_post(); ?>
<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );?>
<section class="product_top" style="background-image: url('<?php echo $thumb['0'];?>')">
    <div class="container">
        <div class="product_top__wrapper product_top_wrap">
            <div class="product_top_wrap__pretitle">
                <h2 class="title"><?php the_field('product_page_top_title'); ?></h2>
            </div>
            <div class="product_top_wrap__title">
                <h1 class="title"><?php the_title(); ?></h1>
            </div>
            <div class="product_top_wrap__text">
                 <?php the_content(); ?>
            </div>
        </div>
    </div>
</section>
<?php endwhile; ?>
<!--end product top-->
<!--begin product navigation-->
<section class="product_navigation">
    <div class="container">
        <div class="product_navigation__list">
            <?php wp_nav_menu( array('menu' => 'Pm' )); ?>
        </div>
    </div>
</section>
<!--end product navigation-->
<!--begin product pack-->
<section class="product_pack">
    <div class="container">
        <div class="product_pack__wrapper product_pack_wrap">
            <?php if( have_rows('product_pack_list') ): ?>
                <?php while( have_rows('product_pack_list') ): the_row(); 
                    // vars
                    $title = get_sub_field('product_pack_title');
                    $list = get_sub_field('product_pack_list');
                    $text = get_sub_field('product_pack_button_text');
                    $link = get_sub_field('product_pack_button_link');
                    $price = get_sub_field('product_pack_price');
                    ?>
                    <!--begin product pack item-->
                    <div class="product_pack_wrap__item product_pack_item">
                        <!-- <?php if( $price) : ?>
                            <div class="product_pack_item__price"><?php echo $price; ?></div>
                        <?php endif; ?> -->
                        <div class="product_pack_item__top">
                            <div class="product_pack_item__title">
                                <h3 class="title">
                                    <?php if( $title ): ?><?php echo $title; ?><?php endif; ?>
                                </h3>
                            </div>
                            <div class="product_pack_item__list">
                                <?php if( $list ): ?><?php echo $list; ?><?php endif; ?>
                            </div>
                        </div>
                       <!--  <div class="product_pack_item__btn">
                            <a href="<?php if( $link ): ?><?php echo $link; ?><?php endif; ?>"><?php if( $text ): ?><?php echo $text; ?><?php endif; ?></a>
                        </div>  -->
                    </div>
                    <!--end product pack item-->
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<!--end product pack-->

<!--begin product methods-->
<section id="methods" class="product_methods">
    <div class="container">
        <div class="product_methods__title s_title_line">
            <h2 class="title">
                <?php the_field('product_methods_title'); ?>
            </h2>
        </div>
        <div class="path__wrapper path_wrap">
            <?php if( have_rows('product_methods_list') ): ?>
                <?php while( have_rows('product_methods_list') ): the_row(); 
                    // vars
                    $title = get_sub_field('product_methods_list_title');
                    $text = get_sub_field('product_methods_list_text');
                    $price = get_sub_field('product_method_price');
                    $button_text = get_sub_field('product_method_button_text');
                    $link = get_sub_field('product_method_button_link');

                    ?>
                    <!--begin path item-->
                    <div class="path_wrap__item path_item">
                        <?php if( $price) : ?>
                            <div class="product_pack_item__price"><?php echo $price; ?></div>
                        <?php endif; ?>
                        <div class="path_item__title">
                            <h3 class="title"><?php if( $title ): ?><?php echo $title; ?><?php endif; ?></h3>
                        </div>
                        <div class="path_item__content">
                            <div class="path_item__text">
                                <?php if( $text ): ?><?php echo $text; ?><?php endif; ?>
                            </div>
                        </div>
                        <div class="product_method_button">
                            <a href="<?php if( $link ): ?><?php echo $link; ?><?php endif; ?>"><?php if( $button_text ): ?><?php echo $button_text; ?><?php endif; ?></a>
                        </div> 
                    </div>
                    <!--end path item-->
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<!--end product methods-->








<!--begin product about-->
<section id="about" class="product_about">
    <div class="container">
        <div class="product_about__title s_title_line">
            <h2 class="title"><?php the_field('product_about_title'); ?></h2>
        </div>
        <div class="product_about__text">
            <?php the_field('product_about_text'); ?>
        </div>
    </div>
</section>
<!--end product about-->
<!--begin product features-->
<section id="features" class="product_features">
    <div class="container">
        <div class="product_features__title s_title_line">
            <h2 class="title"><?php the_field('product_features_title'); ?></h2>
        </div>
        <div class="product_features__text">
            <?php the_field('product_features_text'); ?>
        </div>
        <div class="product_features__list product_features_list">
            <div class="product_features_list__left">
                <ul>
                    <?php if( have_rows('product_features_list_left') ): ?>
                        <?php while( have_rows('product_features_list_left') ): the_row(); 
                            // vars
                            $number = get_sub_field('features_list_left_number');
                            $text = get_sub_field('features_list_left_text');

                            ?>
                            <li>
                                <span><?php if( $number ): ?><?php echo $number; ?><?php endif; ?></span>
                                <?php if( $text ): ?><?php echo $text; ?><?php endif; ?>
                            </li>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="product_features_list__right">
                <ul>
                    <?php if( have_rows('product_features_list_right') ): ?>
                        <?php while( have_rows('product_features_list_right') ): the_row(); 
                            // vars
                            $number = get_sub_field('features_list_right_number');
                            $text = get_sub_field('features_list_right_text');

                            ?>
                            <li>
                                <span><?php if( $number ): ?><?php echo $number; ?><?php endif; ?></span>
                                <?php if( $text ): ?><?php echo $text; ?><?php endif; ?>
                            </li>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<!--end product features-->
<!--begin product audience-->
<section id="audience" class="product_audience">
    <div class="container">
        <div class="product_audience__wrapper product_audience_wrap">
            <div class="product_audience__item product_audience_item">
                <div class="product_audience_item__left">
                    <div class="product_audience_item__title s_title_line">
                        <h2 class="title"><?php the_field('product_audience_title_left'); ?></h2>
                    </div>
                    <div class="product_wrap_item__list">
                        <?php the_field('product_audience_list'); ?>
                    </div>
                </div>
                <div class="product_audience_item__left">
                    <div class="product_audience_item__title s_title_line">
                        <h2 class="title"><?php the_field('product_audience_title_right'); ?></h2>
                    </div>
                    <div class="product_audience_item__list">
                        <?php the_field('product_audience_list_right'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--end product audience-->


<!--begin product preview-->
<section id="preview" class="product_preview">
    <div class="container">
        <div class="product_preview__top product_preview_top">
            <div class="product_preview_top__title">
                <h2 class="title"><?php the_field('preview_title'); ?></h2>
            </div>
            <div class="product_preview_top__btn">
                <a href="<?php the_field('preview_download_link'); ?>">
                    <i><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icon_download.svg" alt="Download"></i>
                    Download
                </a>
            </div>
        </div>
        <?php 
                if( have_rows('preview_list') ): ?>
                    <!--begin path item-->
                    
                    <?php 
                    while( have_rows('preview_list') ): the_row(); ?>
                    <div class="product_preview__list preview_list">
                        <div>
                             <div class="preview_list__title accordion">
                                <h3 class="title"><?php the_sub_field('preview_list_title'); ?></h3>
                            </div>
                            <?php 

                            if( have_rows('preview_list_part') ): ?>
                                <div class="preview_list__info panel">
                                <?php 

                                while( have_rows('preview_list_part') ): the_row();

                                    ?>
                                    <?php if( get_field('field_name') ): ?>
                                        <p>My field value: <?php the_field('field_name'); ?></p>
                                    <?php endif; ?>
                                    <a class="open-popup-link <?php the_sub_field('preview_list_part_class'); ?>" href="#<?php the_sub_field('preview_list_part_id'); ?>"><?php the_sub_field('preview_list_part_title'); ?>
                                    </a>
                                   
                                        <div id="<?php the_sub_field('preview_list_part_id'); ?>" class="white-popup mfp-hide">
                                          <?php the_sub_field('preview_list_video'); ?>
                                        </div>
                                  
                                <?php endwhile; ?>
                                </div>
                            <?php endif;?>
                        </div>  
                                  </div>
                    <?php endwhile ?>
          
                <?php endif; ?>
    </div>
</section>
<!--end product preview-->




<!--begin product outline-->
<section id="outline" class="product_outline">
    <div class="container">
        <div class="product_outline__title s_title_line">
            <h2 class="title"><?php the_field('product_outline_title'); ?></h2>
        </div>
        <div class="product_outline__wrapper product_outline_wrap">
            <div class="product_outline_wrap__left product_outline_left">
                <div class="product_outline_left__title">
                    <h3 class="title"><?php the_field('product_outline_left_title'); ?></h3>
                </div>
                <div class="product_outline_left__text">
                    <?php the_field('product_outline_left_text'); ?>
                </div>
            </div>
            <div class="product_outline_wrap__right product_outline_right">
                <!--begin methods item-->
                <div class="product_outline_right__item product_outline_item">
                    <div class="product_outline_item__title">
                        <h3 class="title">
                            <?php the_field('product_outline_center_title'); ?>
                        </h3>
                    </div>
                    <div class="product_outline_item__numbers">
                        <?php the_field('product_outline_center_text'); ?>
                    </div>
                </div>
                <!--end methods item-->
                <!--begin methods item-->
                <div class="product_outline_right__item product_outline_item">
                    <div class="product_outline_item__title">
                        <h3 class="title">
                             <?php the_field('product_outline_right_title'); ?>
                        </h3>
                    </div>
                    <div class="product_outline_item__numbers">
                         <?php the_field('product_outline_right_text'); ?>
                    </div>
                </div>
                <!--end methods item-->
            </div>
        </div>
    </div>
</section>
<!--end product outline-->


<!--begin product exam-->
<section id="exam" class="product_exam">
    <div class="container">
        <div class="product_exam__title s_title_line">
           <h2 class="title">
               <?php the_field('product_exam_title'); ?>
           </h2>
        </div>
        <div class="product_exam__wrapper product_exam_wrap">
            <div class="line"></div>
            <?php if( have_rows('product_exam_list') ): ?>
                <?php while( have_rows('product_exam_list') ): the_row(); 
                    // vars
                    $title = get_sub_field('product_exam_list_title');
                    $icon = get_sub_field('product_exam_list_icon');
                    ?>
                    <!--begin benefits item-->
                    <div class="product_exam__item product_exam_item">
                        <div class="product_exam_item__icon">
                            <img src="<?php echo $icon['url']; ?>" alt="<?php echo $icon['alt'] ?>" />
                        </div>
                        <div class="product_exam_item__title">
                            <h2 class="title">
                                <?php if( $title ): ?><?php echo $title; ?><?php endif; ?>
                            </h2>
                        </div>
                    </div>
                    <!--end benefits item-->
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<!--end product exam-->


<!--begin product request-->
<?php  
$special_request_title = get_field('special_request_title');
$specieal_request_contact_button = get_field('specieal_request_contact_button');
$special_request_button_link = get_field('special_request_button_link');
?>

<?php if ($special_request_title) { ?> 
<section id="request" class="product_request">
    <div class="container">
        <div class="product_exam__title s_title_line request_title__wrapper ">
           <h2 class="title product-request_title request_title">
                <?php echo $special_request_title; ?>
           </h2>
        </div>
        <div class="contact_us_button__wrapper">
            <a href="<?php echo $special_request_button_link; ?>"><?php echo $specieal_request_contact_button; ?></a>
        </div>
    </div>
</section>
<?php } ?>
<!--end product request-->



<!--begin product faqs-->
<section id="faqs" class="product_faqs">
    <div class="container">
        <div class="product_faqs__title s_title_line">
            <h2 class="title"><?php the_field('product_faqs_title'); ?></h2>
        </div>
        <div class="product_faqs__wrapper product_faqs_wrap">
            <div class="product_faqs_wrap__left product_faqs_left">
                <?php the_field('product_faqs_left'); ?>
            </div>
            <div class="product_faqs_wrap__right product_faqs_right">
               <?php the_field('product_faqs_right'); ?>
            </div>
        </div>
    </div>
</section>
<!--enf product faqs-->
<!--begin product declaimer-->
<section class="product_declaimer">
    <div class="container">
        <div class="product_declaimer__wrapper product_declaimer_wrap">
            <div class="product_declaimer_wrap__title">
                <h2 class="title"><?php the_field('product_desclimer_title'); ?></h2>
            </div>
            <div class="product_declaimer_wrap__text">
                <?php the_field('product_desclimer_text'); ?>
            </div>
        </div>
    </div>
</section>
<!--end product declaimer-->
<?php get_footer(); ?>