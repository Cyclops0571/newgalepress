<!-- Tickets: Live Chat Bar Start -->
<!--<div id="lcs"><a href="#" id="lcs_start_chat">{{__('website.footer_livechat')}}</a></div>-->
<!-- Tickets: Live Chat Bar Finish -->
<?php
$socialMediaLinks = array();
$socialMediaLinks['fa-linkedin'] = __('common.fa-linkedin');
$socialMediaLinks['fa-twitter'] = __('common.fa-twitter');
$socialMediaLinks['fa-facebook'] = __('common.fa-facebook');
$socialMediaLinks['fa-instagram'] = __('common.fa-instagram');
?>
<footer id="footer">
    <div class="inner sep-bottom-sm">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="widget sep-top-md">
                        <h6 class="upper widget-title">{{__('website.footer_socialmedia')}}</h6>
                        <ul class="social-icon sep-top-xs">
                            <?php foreach($socialMediaLinks as $faIcon => $url): ?>
                            <li><a href="<?php echo $url ?>" class="fa <?php echo $faIcon ?> fa-lg" target="_blank"></a></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php if( Config::get("application.language") != 'usa'): ?>
                        <ul class="social-icon sep-top-xs">
                            <li>
                                <small class="sep-top-xs sep-bottom-md">{{__('website.get_in_touch_desc')}}<br/>
                                    <small class="alert alert-success hidden"
                                           id="newsletterSuccess">{{__('website.newsletter_success')}}</small>
                                    <small class="alert alert-error hidden" id="newsletterError"></small>

                                    <form class="form-inline" id="newsletterForm"
                                          action="/website/php/newsletter-subscribe.php" method="POST">
                                        <div class="input-group input-group-sm" style="margin-top:8px;">
                                            <span class="input-group-addon newsletter"><i class="fa fa-envelope-o"></i></span>
                                            <input type="text" name="email" id="email"
                                                   class="form-control newsletter-text-input"
                                                   aria-label="email registration">
                                                <span class="input-group-btn">
                                                <button class="btn btn-default newsletter"
                                                        type="submit">{{__('website.newsletter_subscription')}}</button>
                                                </span>
                                        </div>
                                    </form>
                                </small>
                            </li>
                        </ul>
                        <?php endif; ?>

                    </div>
                </div>
                <div class="col-md-8">
                    <?php if( Config::get("application.language") == 'tr'): ?>
                    <div class="col-md-9 col-md-offset-3 sep-top-md">
                        <h6 class="upper widget-title">{{__('website.contact')}}</h6>
                    </div>
                    <div class="col-md-4  col-md-offset-3" style="border-right: 1px solid grey">
                        <div class="widget">
                            <ul class="widget-address sep-top-xs">
                                <li><a href="<?php echo __("route.website_contact")?>"><i
                                                class="fa fa-map-marker fa-lg"></i>
                                        <small>{{__('website.address_usa')}}</small>
                                    </a></li>
                                <li><i class="fa fa-phone fa-lg"></i>
                                    <small>+1-949-836-7342</small>
                                </li>
                                <li><a href="<?php echo __("route.website_contact")?>"><i
                                                class="fa fa-map-marker fa-lg"></i>
                                        <small>{{__('website.address_usa2')}}</small>
                                    </a></li>
                                <li><i class="fa fa-phone fa-lg"></i>
                                    <small>+1-973-462-6622</small>
                                </li>
                                <li><i class="fa fa-envelope fa-lg"></i><a href="mailto:usa@galepress.com">usa@galepress
                                        .com</a></small></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="widget">
                            <ul class="widget-address sep-top-xs">
                                <li><a href="<?php echo __("route.website_contact")?>"><i
                                                class="fa fa-map-marker fa-lg"></i>
                                        <small>{{__('website.address_istanbul')}}</small>
                                    </a></li>
                                <li><i class="fa fa-phone fa-lg"></i>
                                    <small>+90 (216) 443 13 29</small>
                                </li>
                                <li><i class="fa fa-fax fa-lg"></i>
                                    <small>+90 (216) 443 08 27</small>
                                </li>
                                <li><i class="fa fa-envelope fa-lg"></i>
                                    <small><a href="mailto:info@galepress.com">info@galepress.com</a></small>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="col-md-4 col-md-offset-8 sep-top-md">
                        <h6 class="upper widget-title">{{__('website.contact')}}</h6>
                    </div>
                    <div class="col-md-4  col-md-offset-8">
                        <div class="widget">
                            <ul class="widget-address sep-top-xs">
                                <li><a href="<?php echo __("route.website_contact")?>"><i
                                                class="fa fa-map-marker fa-lg"></i>
                                        <small>{{__('website.address_usa')}}</small>
                                    </a></li>
                                <li><i class="fa fa-phone fa-lg"></i>
                                    <small>+1-949-836-7342</small>
                                </li>
                                <li><a href="<?php echo __("route.website_contact")?>"><i
                                                class="fa fa-map-marker fa-lg"></i>
                                        <small>{{__('website.address_usa2')}}</small>
                                    </a></li>
                                <li><i class="fa fa-phone fa-lg"></i>
                                    <small>+1-973-462-6622</small>
                                </li>
                                <li><i class="fa fa-envelope fa-lg"></i><a href="mailto:usa@galepress.com">usa@galepress
                                        .com</a></small></li>
                            </ul>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
    <?php $footerCopyWrite = (string)__('website.footer_copyright'); ?>
    <?php if(!empty($footerCopyWrite)): ?>
    <div class="copyright sep-top-xs sep-bottom-xs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <small><?php echo $footerCopyWrite; ?></small>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</footer>