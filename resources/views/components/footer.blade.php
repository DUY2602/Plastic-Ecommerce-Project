<!-- Footer Section Begin -->
<footer class="footer spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__about">
                    <ul>
                        <li>Address: 123 Nguyen Van Linh, District 7, Ho Chi Minh City</li>
                        <li>Phone: +84 123 456 789</li>
                        <li>Email: hello@plastic.com</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                <div class="footer__widget">
                    <h6>Useful Links</h6>
                    <ul>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                        <li><a href="{{ route('blog.index') }}">Blog</a></li>
                        <li><a href="#"></a></li>
                    </ul>
                    <ul>
                        <li><a href="{{ route('category', 'pet') }}">PET Products</a></li>
                        <li><a href="{{ route('category', 'pp') }}">PP Products</a></li>
                        <li><a href="{{ route('category', 'pc') }}">PC Products</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="footer__widget">
                    <h6>Subscribe to Newsletter</h6>
                    <p>Receive updates about new products and special promotions.</p>
                    <form action="#">
                        <input type="text" placeholder="Enter your email">
                        <button type="submit" class="site-btn">Subscribe</button>
                    </form>
                    <div class="footer__widget__social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="footer__copyright">
                    <div class="footer__copyright__text">
                        <p>&copy; {{ date('Y') }} Plastic Ecommerce. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->