<footer>
    <!-- BEGIN INFORMATIVE FOOTER -->
    <div class="footer-inner">
        <div class="newsletter-row">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col">
                        <!-- Footer Payment Link -->
                        <div class="payment-accept">
                            <div>
                                <img src="/images/payment-1.png" alt="payment1">
                                <img src="/images/payment-2.png" alt="payment2">
                                <img src="/images/payment-3.png" alt="payment3">
                                <img src="/images/payment-4.png" alt="payment4">
                            </div>
                        </div>
                    </div>
                    <!-- Footer Newsletter -->
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 col1">
                        <div class="newsletter-wrap">
                            <h4>Sign up for emails</h4>
                            <form action="#" method="post" id="newsletter-validate-detail1">
                                <div id="container_form_news">
                                    <div id="container_form_news2">
                                        <input type="text" name="email" id="newsletter1" title="Sign up for our newsletter" class="input-text required-entry validate-email" placeholder="Enter your email address">
                                        <button type="submit" title="Subscribe" class="button subscribe"><span>Subscribe</span></button>
                                    </div>
                                    <!--container_form_news2-->
                                </div>
                                <!--container_form_news-->
                            </form>
                        </div>
                        <!--newsletter-wrap-->
                    </div>
                </div>
            </div>
            <!--footer-column-last-->
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-xs-12 col-lg-4">
                    <div class="co-info">
                        <h4>Contact Us</h4>
                        <address>
                            <div><em class="icon-location-arrow"></em> <span>{{ $options->getOption('contact_address') }}</span></div>
                            <div> <em class="icon-mobile-phone"></em><span> {{ $options->getOption('contact_phone_number') }}</span></div>
                            <div> <em class="icon-envelope"></em><span>{{ $options->getOption('contact_email') }}</span></div>
                        </address>
                        <div class="social">

                            <ul class="link">
                                <li class="fb pull-left"><a target="_blank" rel="nofollow" href="{{ $options->getOption('facebook_link') }}" title="Facebook"></a></li>
                                <li class="tw pull-left"><a target="_blank" rel="nofollow" href="{{ $options->getOption('twitter_link') }}" title="Twitter"></a></li>
                                <li class="linkedin pull-left"><a target="_blank" rel="nofollow" href="{{ $options->getOption('linkedin_link') }}" title="Linkedin"></a></li>
                                <li class="youtube pull-left"><a target="_blank" rel="nofollow" href="{{ $options->getOption('youtube_link') }}" title="Youtube"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-8 col-xs-12 col-lg-8">
                    <div class="footer-column">
                        <h4>Customer Service</h4>
                        <ul class="links">
                            <li class="first"><a href="#" title="Contact us">My Account</a></li>
                            <li><a href="#" title="About us">Order History</a></li>
                            <li><a href="#" title="faq">FAQ</a></li>
                            <li><a href="#" title="Popular Searches">Specials</a></li>
                            <li class="last"><a href="#" title="Where is my order?">Help Center</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h4>Corporation</h4>
                        <ul class="links">
                            <li class="first"><a title="Your Account" href="#">About us</a></li>
                            <li><a title="Information" href="#">Customer Service</a></li>
                            <li><a title="Addresses" href="#">Company</a></li>
                            <li><a title="Addresses" href="#">Investor Relations</a></li>
                            <li class="last"><a title="Orders History" href="#">Advanced Search</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h4>Why choose Us</h4>
                        <ul class="links">
                            <li class="first"><a href="#" title="About us">Shopping Guide</a></li>
                            <li><a href="#" title="Blog">Blog</a></li>
                            <li><a href="#" title="Company">Company</a></li>
                            <li><a href="#" title="Investor Relations">Investor Relations</a></li>
                            <li class=" last"><a href="contact-us.html" title="Suppliers">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <!--col-sm-12 col-xs-12 col-lg-8-->
                <!--col-xs-12 col-lg-4-->
            </div>
            <!--row-->
        </div>
        <!--container-->
    </div>
    <!--footer-inner-->

    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="our-features-box wow bounceInUp animated animated">
                    <div class="container">
                        <ul>
                            <li>
                                <div class="feature-box free-shipping">
                                    <div class="icon-truck"></div>
                                    <div class="content">Free Shipping on order over $99</div>
                                </div>
                            </li>
                            <li>
                                <div class="feature-box need-help">
                                    <div class="icon-support"></div>
                                    <div class="content">Need Help +(888) 123-4567</div>
                                </div>
                            </li>
                            <li>
                                <div class="feature-box money-back">
                                    <div class="icon-money"></div>
                                    <div class="content">Money Back Guarantee</div>
                                </div>
                            </li>
                            <li class="last">
                                <div class="feature-box return-policy">
                                    <div class="icon-return"></div>
                                    <div class="content">30 days return Service</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--row-->
        </div>
        <!--container-->
    </div>
    <!-- BEGIN SIMPLE FOOTER -->
</footer>