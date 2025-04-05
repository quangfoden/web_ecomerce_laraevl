<?php

/** @var \Illuminate\Database\Eloquent\Collection $products */
$categoryList = \App\Models\Category::getActiveAsTree();

?>
<footer class="footer bg-footer" data-aos="fade-up">
    <a href="https://www.dmca.com/Protection/Status.aspx?ID=e12b6a20-f42d-4e06-ae66-31570fdb7b74&amp;refurl=https://kaiwinsport.com/" title="DMCA.com Protection Status" class="dmca-badge"> <img src="https://images.dmca.com/Badges/dmca_protected_sml_120l.png?ID=e12b6a20-f42d-4e06-ae66-31570fdb7b74" alt="DMCA.com Protection Status"></a>
    <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script>
    <div class="site-footer">
        <div class="container">
            <div class="footer-inner padding-bottom-10 padding-top-10">
                <div class="row footer-show-more-group">
                    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 fix-clear">
                        <div class="footer-widget">
                            <h3>Về H2C Sports</h3>
                            <div class="contactll">
                                <p>CÔNG TY&nbsp;CỔ&nbsp;PHẦN&nbsp;H2C SPORT&nbsp;VIỆT NAM</p>
                                <p>Số ĐKKD :&nbsp;0109316876,&nbsp;ngày cấp: 20/08/2020, nơi cấp: Sở kế hoạch và đầu tư Hà Nội</p>
                                <p>Trụ sở chính:&nbsp;Tầng 2 số 47 Ngọc Đại, Phường Đại Mỗ, Quận Nam Từ Liêm, TP Hà Nội</p>
                                <p>Số điện thoại:&nbsp;0357.670.233</p>
                                <p>Email:&nbsp;h2csports@gmail.com</p>
                            </div>
                            <a href="http://online.gov.vn/Home/WebDetails/101456" target="_blank"><img src="//bizweb.dktcdn.net/100/017/070/themes/778721/assets/logo_bct.png?1739265273239" style="max-width:50%"></a>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 fix-clear">
                        <div class="footer-widget">
                            <h3>Sản phẩm</h3>
                            <ul class="list-menu has-click">
                                @foreach($categoryList as $category)
                                <li><a href="{{ route('byCategory', $category) }}" title="BÓNG ĐÁ" rel="nofollow"> {{$category->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 fix-clear">
                        <div class="footer-widget form-mailchimp">
                            <h3>Hỗ trợ khách hàng</h3>
                            <ul class="list-menu has-click">
                                <li><a href="/chinh-sach-bao-mat-thong-tin" title="Chính sách bảo mật thông tin" rel="nofollow">Chính sách bảo mật thông tin</a></li>
                                <li><a href="/chinh-sach-van-chuyen" title="Chính sách vận chuyển" rel="nofollow">Chính sách vận chuyển</a></li>
                                <li><a href="/chinh-sach-thanh-toan" title="Chính sách thanh toán" rel="nofollow">Chính sách thanh toán</a></li>
                                <li><a href="/chinh-sach-bao-hanh-sp" title="Chính sách đổi trả sản phẩm" rel="nofollow">Chính sách đổi trả sản phẩm</a></li>
                                <li><a href="/chinh-sach-kiem-hang" title="Chính sách kiểm hàng" rel="nofollow">Chính sách kiểm hàng</a></li>
                                <li><a href="/tuyen-ctv" title="Tuyển CTV" rel="nofollow">Tuyển CTV</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 fix-clear">
                        <div class="footer-widget footer-mailchimp">
                            <h3>Đăng ký nhận tin từ H2C Sports</h3>
                            <div class="content_ff">
                                Đăng ký nhận bản tin của chúng tôi và luôn cập nhật
                                với bộ sưu tập mới nhất, những xu hướng mới nhất và những giao dịch tốt nhất!
                            </div>
                            <form action="//facebook.us7.list-manage.com/subscribe/post?u=97ba6d3ba28239250923925a8&amp;id=4ef3a755a8" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank" class="has-validation-callback">
                                <input type="email" class="form-control" value="" placeholder="Email của bạn" name="EMAIL" id="mail" aria-label="Đăng ký nhận tin">
                                <button name="subscribe" id="subscribe"><img src="//bizweb.dktcdn.net/100/017/070/themes/778721/assets/paper-plane.png?1739265273239" alt="Đăng ký"></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright clearfix">
        <div class="container">
            <div class="row" style="padding-block: 10px;">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="sap_cont">
                        <span>© Bản quyền thuộc về <b>H2C SPORT</b> <span class="s480-f">|</span> Cung cấp bởi <a href="https://www.sapo.vn/?utm_campaign=cpn:site_khach_hang-plm:footer&amp;utm_source=site_khach_hang&amp;utm_medium=referral&amp;utm_content=fm:text_link-km:-sz:&amp;utm_term=&amp;campaign=site_khach_hang" title="Sapo" target="_blank" rel="nofollow">Sapo</a></span>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="footer-widget footer-contact">
                        <ul class="footer-social">
                            <li class="facebook">
                                <a href="https://facebook.com/kaiwinsport" title="Facebook" target="_blank" rel="nofollow" aria-label="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                            <li class="twitter">
                                <a href="#" title="Twitter" target="_blank" rel="nofollow" aria-label="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                            <li class="instagram">
                                <a href="#" title="Instagram" target="_blank" rel="nofollow" aria-label="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>
                            <li class="youtube">
                                <a href="https://www.youtube.com/watch?v=HZBoBqaCLi8" title="Youtube" target="_blank" rel="nofollow" aria-label="Youtube">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>