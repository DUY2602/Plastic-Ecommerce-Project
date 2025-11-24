<!-- Footer Section Begin -->
<footer class="footer spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__about__logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('img/logo.png') }}" alt="Plastic Store"></a>
                    </div>
                    <ul>
                        <li>Địa chỉ: 123 Nguyễn Văn Linh, Quận 7, TP.HCM</li>
                        <li>Điện thoại: +84 123 456 789</li>
                        <li>Email: hello@plastic.com</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                <div class="footer__widget">
                    <h6>Liên kết hữu ích</h6>
                    <ul>
                        <li><a href="{{ route('about') }}">Về chúng tôi</a></li>
                        <li><a href="{{ route('contact') }}">Liên hệ</a></li>
                        <li><a href="#">Chính sách bảo mật</a></li>
                        <li><a href="#">Điều khoản sử dụng</a></li>
                    </ul>
                    <ul>
                        <li><a href="{{ route('category', 'pet') }}">Sản phẩm PET</a></li>
                        <li><a href="{{ route('category', 'pp') }}">Sản phẩm PP</a></li>
                        <li><a href="{{ route('category', 'pc') }}">Sản phẩm PC</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="footer__widget">
                    <h6>Đăng ký nhận tin</h6>
                    <p>Nhận thông tin cập nhật về sản phẩm mới và khuyến mãi đặc biệt.</p>
                    <form action="#">
                        <input type="text" placeholder="Nhập email của bạn">
                        <button type="submit" class="site-btn">Đăng ký</button>
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