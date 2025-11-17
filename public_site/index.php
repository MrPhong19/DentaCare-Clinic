<?php
session_start();
require_once '../config/db.php';

$success = $error = '';
if (isset($_SESSION['appointment_success'])) {
    $success = $_SESSION['appointment_success'];
    unset($_SESSION['appointment_success']);
}
if (isset($_SESSION['appointment_error'])) {
    $error = $_SESSION['appointment_error'];
    unset($_SESSION['appointment_error']);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>DentaCare - Free Bootstrap 4 Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700" rel="stylesheet">
<!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- CSS: dùng relative path thay vì C:\... -->
    <link rel="stylesheet" href="assets/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">

    <link rel="stylesheet" href="assets/css/aos.css">

    <link rel="stylesheet" href="assets/css/ionicons.min.css">

    <link rel="stylesheet" href="assets/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/icomoon.css">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    
	  <!-- NAVIGATION -->
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
      <div class="container">
        <a class="navbar-brand" href="index.php">Denta<span>Care</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav">
          <span class="oi oi-menu"></span> Menu
        </button>
        <div class="collapse navbar-collapse" id="ftco-nav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
            <li class="nav-item"><a href="services.php" class="nav-link">Services</a></li>
            <li class="nav-item"><a href="doctors.php" class="nav-link">Doctors</a></li>
            <li class="nav-item"><a href="blog.php" class="nav-link">Blog</a></li>
            <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
            <li class="nav-item cta"><a href="#" class="nav-link" data-toggle="modal" data-target="#modalRequest"><span>Đặt lịch khám</span></a></li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- END nav -->

    <section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url('assets/images/bg_1.jpg');">
      <div class="overlay"></div>
      <div class="container">
        <div class="row slider-text align-items-center">
          <div class="col-md-6 col-sm-12 ftco-animate">
            <h1 class="mb-4">Nha khoa hiện đại &amp; thân thiện</h1>
            <p class="mb-4">Đặt lịch nhanh chóng – Chăm sóc tận tâm.</p>
            <p><a href="#" class="btn btn-primary px-4 py-3" data-toggle="modal" data-target="#modalRequest">Đặt lịch ngay</a></p>
          </div>
        </div>
      </div>
    </div>
    <div class="slider-item" style="background-image: url('assets/images/bg_2.jpg');">
      <div class="overlay"></div>
      <div class="container">
        <div class="row slider-text align-items-center">
          <div class="col-md-6 col-sm-12 ftco-animate">
            <h1 class="mb-4">Nụ cười hoàn hảo – Bắt đầu từ đây</h1>
            <p><a href="#" class="btn btn-primary px-4 py-3" data-toggle="modal" data-target="#modalRequest">Đặt lịch khám</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>

    <!-- FORM ĐẶT LỊCH -->
    <section class="ftco-intro">
      <div class="container">
        <div class="row no-gutters">
          <div class="col-md-3 color-1 p-4">
            <h3 class="mb-4">Khẩn cấp</h3>
            <p>Liên hệ ngay khi cần hỗ trợ</p>
            <span class="phone-number">+84 123 456 789</span>
          </div>
          <div class="col-md-3 color-2 p-4">
            <h3 class="mb-4">Giờ mở cửa</h3>
            <p class="openinghours d-flex"><span>Thứ 2 - Thứ 6</span><span>8:00 - 19:00</span></p>
            <p class="openinghours d-flex"><span>Thứ 7</span><span>10:00 - 17:00</span></p>
            <p class="openinghours d-flex"><span>Chủ nhật</span><span>10:00 - 16:00</span></p>
          </div>
          <div class="col-md-6 color-3 p-4">
            <h3 class="mb-2">Đặt lịch khám</h3>

            <!-- FORM ĐÃ ĐƯỢC THỐNG NHẤT -->
            <form id="appointmentForm" class="appointment-form">
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                    <div class="select-wrap">
                      <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                      <select name="department" class="form-control" required>
                        <option value="">Chọn dịch vụ</option>
                        <option value="Tẩy trắng răng">Tẩy trắng răng</option>
                        <option value="Cạo vôi răng">Cạo vôi răng</option>
                        <option value="Niềng răng">Niềng răng</option>
                        <option value="Cấy ghép Implant">Cấy ghép Implant</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <div class="icon"><span class="icon-user"></span></div>
                    <input type="text" name="name" class="form-control" placeholder="Họ tên" required>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <div class="icon"><span class="icon-paper-plane"></span></div>
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                    <div class="icon"><span class="ion-ios-calendar"></span></div>
                    <input type="text" name="date" class="form-control appointment_date" placeholder="Ngày" required>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <div class="icon"><span class="ion-ios-clock"></span></div>
                    <input type="text" name="time" class="form-control appointment_time" placeholder="Giờ" required>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <div class="icon"><span class="icon-phone2"></span></div>
                    <input type="text" name="phone" class="form-control" placeholder="SĐT" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <textarea name="reason" class="form-control" rows="2" placeholder="Ghi chú (tùy chọn)"></textarea>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Đặt lịch ngay</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  
    <section class="ftco-section ftco-services">
      <div class="container">
      	<div class="row justify-content-center mb-5 pb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <h2 class="mb-2">Our Service Keeps you Smile</h2>
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-block text-center">
              <div class="icon d-flex justify-content-center align-items-center">
            		<span class="flaticon-tooth-1"></span>
              </div>
              <div class="media-body p-2 mt-3">
                <h3 class="heading">Teeth Whitening</h3>
                <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>
              </div>
            </div>      
          </div>
          <div class="col-md-3 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-block text-center">
              <div class="icon d-flex justify-content-center align-items-center">
            		<span class="flaticon-dental-care"></span>
              </div>
              <div class="media-body p-2 mt-3">
                <h3 class="heading">Teeth Cleaning</h3>
                <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>
              </div>
            </div>    
          </div>
          <div class="col-md-3 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-block text-center">
              <div class="icon d-flex justify-content-center align-items-center">
            		<span class="flaticon-tooth-with-braces"></span>
              </div>
              <div class="media-body p-2 mt-3">
                <h3 class="heading">Quality Brackets</h3>
                <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>
              </div>
            </div>      
          </div>
          <div class="col-md-3 d-flex align-self-stretch ftco-animate">
            <div class="media block-6 services d-block text-center">
              <div class="icon d-flex justify-content-center align-items-center">
            		<span class="flaticon-anesthesia"></span>
              </div>
              <div class="media-body p-2 mt-3">
                <h3 class="heading">Modern Anesthetic</h3>
                <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic.</p>
              </div>
            </div>      
          </div>
        </div>
      </div>
      <div class="container-wrap mt-5">
      	<div class="row d-flex no-gutters">
      		<div class="col-md-6 img" style="background-image: url('assets/images/about-2.jpg');">
      		</div>
      		<div class="col-md-6 d-flex">
      			<div class="about-wrap">
      				<div class="heading-section heading-section-white mb-5 ftco-animate">
		            <h2 class="mb-2">Dentacare with a personal touch</h2>
		            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
		          </div>
      				<div class="list-services d-flex ftco-animate">
      					<div class="icon d-flex justify-content-center align-items-center">
      						<span class="icon-check2"></span>
      					</div>
      					<div class="text">
	      					<h3>Well Experience Dentist</h3>
	      					<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
      					</div>
      				</div>
      				<div class="list-services d-flex ftco-animate">
      					<div class="icon d-flex justify-content-center align-items-center">
      						<span class="icon-check2"></span>
      					</div>
      					<div class="text">
	      					<h3>High Technology Facilities</h3>
	      					<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
      					</div>
      				</div>
      				<div class="list-services d-flex ftco-animate">
      					<div class="icon d-flex justify-content-center align-items-center">
      						<span class="icon-check2"></span>
      					</div>
      					<div class="text">
	      					<h3>Comfortable Clinics</h3>
	      					<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
      					</div>
      				</div>
      			</div>
      		</div>
      	</div>
      </div>
    </section>


    <section class="ftco-section">
      <div class="container">
      	<div class="row justify-content-center mb-5 pb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <h2 class="mb-3">Meet Our Experience Dentist</h2>
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences</p>
          </div>
        </div>
        <div class="row">
        	<div class="col-lg-3 col-md-6 d-flex mb-sm-4 ftco-animate">
        		<div class="staff">
      				<div class="img mb-4" style="background-image: url('assets/images/person_5.jpg');"></div>
      				<div class="info text-center">
      					<h3><a href="#">Tom Smith</a></h3>
      					<span class="position">Dentist</span>
      					<div class="text">
	        				<p>Far far away, behind the word mountains, far from the countries Vokalia</p>
	        				<ul class="ftco-social">
			              <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
			              <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
			              <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
			              <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a></li>
			            </ul>
	        			</div>
      				</div>
        		</div>
        	</div>
        	<div class="col-lg-3 col-md-6 d-flex mb-sm-4 ftco-animate">
        		<div class="staff">
      				<div class="img mb-4" style="background-image: url('assets/images/person_6.jpg');"></div>
      				<div class="info text-center">
      					<h3><a href="#">Mark Wilson</a></h3>
      					<span class="position">Dentist</span>
      					<div class="text">
	        				<p>Far far away, behind the word mountains, far from the countries Vokalia</p>
	        				<ul class="ftco-social">
			              <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
			              <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
			              <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
			              <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a></li>
			            </ul>
	        			</div>
      				</div>
        		</div>
        	</div>
        	<div class="col-lg-3 col-md-6 d-flex mb-sm-4 ftco-animate">
        		<div class="staff">
      				<div class="img mb-4" style="background-image: url('assets/images/person_7.jpg');"></div>
      				<div class="info text-center">
      					<h3><a href="#">Patrick Jacobson</a></h3>
      					<span class="position">Dentist</span>
      					<div class="text">
	        				<p>Far far away, behind the word mountains, far from the countries Vokalia</p>
	        				<ul class="ftco-social">
			              <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
			              <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
			              <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
			              <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a></li>
			            </ul>
	        			</div>
      				</div>
        		</div>
        	</div>
        	<div class="col-lg-3 col-md-6 d-flex mb-sm-4 ftco-animate">
        		<div class="staff">
      				<div class="img mb-4" style="background-image: url('assets/images/person_8.jpg');"></div>
      				<div class="info text-center">
      					<h3><a href="#">Ivan Dorchsner</a></h3>
      					<span class="position">System Analyst</span>
      					<div class="text">
	        				<p>Far far away, behind the word mountains, far from the countries Vokalia</p>
	        				<ul class="ftco-social">
			              <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
			              <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
			              <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
			              <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a></li>
			            </ul>
	        			</div>
      				</div>
        		</div>
        	</div>
        </div>
        <div class="row  mt-5 justify-conten-center">
        	<div class="col-md-8 ftco-animate">
        		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi vero accusantium sunt sit aliquam ipsum molestias autem perferendis, incidunt cumque necessitatibus cum amet cupiditate, ut accusamus. Animi, quo. Laboriosam, laborum.</p>
        	</div>
        </div>
      </div>
    </section>

    <section class="ftco-section ftco-counter img" id="section-counter" style="background-image: url('assets/images/bg_1.jpg');" data-stellar-background-ratio="0.5">
    	<div class="container">
    		<div class="row d-flex align-items-center">
    			<div class="col-md-3 aside-stretch py-5">
    				<div class=" heading-section heading-section-white ftco-animate pr-md-4">
	            <h2 class="mb-3">Achievements</h2>
	            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
	          </div>
    			</div>
    			<div class="col-md-9 py-5 pl-md-5">
		    		<div class="row">
		          <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18">
		              <div class="text">
		                <strong class="number" data-number="14">0</strong>
		                <span>Years of Experience</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18">
		              <div class="text">
		                <strong class="number" data-number="4500">0</strong>
		                <span>Qualified Dentist</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18">
		              <div class="text">
		                <strong class="number" data-number="4200">0</strong>
		                <span>Happy Smiling Customer</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18">
		              <div class="text">
		                <strong class="number" data-number="320">0</strong>
		                <span>Patients Per Year</span>
		              </div>
		            </div>
		          </div>
		        </div>
		      </div>
	      </div>
    	</div>
    </section>

    <section class="ftco-section">
    	<div class="container">
    		<div class="row justify-content-center mb-5 pb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <h2 class="mb-3">Our Best Pricing</h2>
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
          </div>
        </div>
    		<div class="row">
        	<div class="col-md-3 ftco-animate">
        		<div class="pricing-entry pb-5 text-center">
        			<div>
	        			<h3 class="mb-4">Basic</h3>
	        			<p><span class="price">$24.50</span> <span class="per">/ session</span></p>
	        		</div>
        			<ul>
        				<li>Diagnostic Services</li>
								<li>Professional Consultation</li>
								<li>Tooth Implants</li>
								<li>Surgical Extractions</li>
								<li>Teeth Whitening</li>
        			</ul>
        			<p class="button text-center"><a href="#" class="btn btn-primary btn-outline-primary px-4 py-3">Order now</a></p>
        		</div>
        	</div>
        	<div class="col-md-3 ftco-animate">
        		<div class="pricing-entry pb-5 text-center">
        			<div>
	        			<h3 class="mb-4">Standard</h3>
	        			<p><span class="price">$34.50</span> <span class="per">/ session</span></p>
	        		</div>
        			<ul>
        				<li>Diagnostic Services</li>
								<li>Professional Consultation</li>
								<li>Tooth Implants</li>
								<li>Surgical Extractions</li>
								<li>Teeth Whitening</li>
        			</ul>
        			<p class="button text-center"><a href="#" class="btn btn-primary btn-outline-primary px-4 py-3">Order now</a></p>
        		</div>
        	</div>
        	<div class="col-md-3 ftco-animate">
        		<div class="pricing-entry active pb-5 text-center">
        			<div>
	        			<h3 class="mb-4">Premium</h3>
	        			<p><span class="price">$54.50</span> <span class="per">/ session</span></p>
	        		</div>
        			<ul>
        				<li>Diagnostic Services</li>
								<li>Professional Consultation</li>
								<li>Tooth Implants</li>
								<li>Surgical Extractions</li>
								<li>Teeth Whitening</li>
        			</ul>
        			<p class="button text-center"><a href="#" class="btn btn-primary btn-outline-primary px-4 py-3">Order now</a></p>
        		</div>
        	</div>
        	<div class="col-md-3 ftco-animate">
        		<div class="pricing-entry pb-5 text-center">
        			<div>
	        			<h3 class="mb-4">Platinum</h3>
	        			<p><span class="price">$89.50</span> <span class="per">/ session</span></p>
	        		</div>
        			<ul>
        				<li>Diagnostic Services</li>
								<li>Professional Consultation</li>
								<li>Tooth Implants</li>
								<li>Surgical Extractions</li>
								<li>Teeth Whitening</li>
        			</ul>
        			<p class="button text-center"><a href="#" class="btn btn-primary btn-outline-primary px-4 py-3">Order now</a></p>
        		</div>
        	</div>
        </div>
    	</div>
    </section>

    <section class="ftco-section-parallax">
      <div class="parallax-img d-flex align-items-center">
        <div class="container">
          <div class="row d-flex justify-content-center">
            <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
              <h2>Subcribe to our Newsletter</h2>
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in</p>
              <div class="row d-flex justify-content-center mt-5">
                <div class="col-md-8">
                  <form action="#" class="subscribe-form">
                    <div class="form-group d-flex">
                      <input type="text" class="form-control" placeholder="Enter email address">
                      <input type="submit" value="Subscribe" class="submit px-3">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
		
		<section class="ftco-section testimony-section bg-light">
      <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <h2 class="mb-2">Testimony</h2>
            <span class="subheading">Our Happy Customer Says</span>
          </div>
        </div>
        <div class="row justify-content-center ftco-animate">
          <div class="col-md-8">
            <div class="carousel-testimony owl-carousel ftco-owl">
              <div class="item">
                <div class="testimony-wrap p-4 pb-5">
                  <div class="user-img mb-5" style="background-image: url('assets/images/person_1.jpg')">
                    <span class="quote d-flex align-items-center justify-content-center">
                      <i class="icon-quote-left"></i>
                    </span>
                  </div>
                  <div class="text text-center">
                    <p class="mb-5">Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
                    <p class="name">Dennis Green</p>
                    <span class="position">Marketing Manager</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap p-4 pb-5">
                  <div class="user-img mb-5" style="background-image: url('assets/images/person_2.jpg')">
                    <span class="quote d-flex align-items-center justify-content-center">
                      <i class="icon-quote-left"></i>
                    </span>
                  </div>
                  <div class="text text-center">
                    <p class="mb-5">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <p class="name">Dennis Green</p>
                    <span class="position">Interface Designer</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap p-4 pb-5">
                  <div class="user-img mb-5" style="background-image: url('assets/images/person_3.jpg')">
                    <span class="quote d-flex align-items-center justify-content-center">
                      <i class="icon-quote-left"></i>
                    </span>
                  </div>
                  <div class="text text-center">
                    <p class="mb-5">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <p class="name">Dennis Green</p>
                    <span class="position">UI Designer</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap p-4 pb-5">
                  <div class="user-img mb-5" style="background-image: url('assets/images/person_1.jpg')">
                    <span class="quote d-flex align-items-center justify-content-center">
                      <i class="icon-quote-left"></i>
                    </span>
                  </div>
                  <div class="text text-center">
                    <p class="mb-5">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <p class="name">Dennis Green</p>
                    <span class="position">Web Developer</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap p-4 pb-5">
                  <div class="user-img mb-5" style="background-image: url('assets/images/person_1.jpg')">
                    <span class="quote d-flex align-items-center justify-content-center">
                      <i class="icon-quote-left"></i>
                    </span>
                  </div>
                  <div class="text text-center">
                    <p class="mb-5">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <p class="name">Dennis Green</p>
                    <span class="position">System Analytics</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
		
		<section class="ftco-gallery">
    	<div class="container-wrap">
    		<div class="row no-gutters">
					<div class="col-md-3 ftco-animate">
						<a href="#" class="gallery img d-flex align-items-center" style="background-image: url('assets/images/gallery-1.jpg');">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-search"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-3 ftco-animate">
						<a href="#" class="gallery img d-flex align-items-center" style="background-image: url('assets/images/gallery-2.jpg');">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-search"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-3 ftco-animate">
						<a href="#" class="gallery img d-flex align-items-center" style="background-image: url('assets/images/gallery-3.jpg');">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-search"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-3 ftco-animate">
						<a href="#" class="gallery img d-flex align-items-center" style="background-image: url('assets/images/gallery-4.jpg');">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-search"></span>
    					</div>
						</a>
					</div>
        </div>
    	</div>
    </section>

    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <h2 class="mb-2">Latest Blog</h2>
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 ftco-animate">
            <div class="blog-entry">
              <a href="blog-single.php" class="block-20" style="background-image: url('assets/images/image_1.jpg');">
              </a>
              <div class="text d-flex py-4">
                <div class="meta mb-3">
                  <div><a href="#">Sep. 20, 2018</a></div>
                  <div><a href="#">Admin</a></div>
                  <div><a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a></div>
                </div>
                <div class="desc pl-3">
	                <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about the blind texts</a></h3>
	              </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 ftco-animate">
            <div class="blog-entry" data-aos-delay="100">
              <a href="blog-single.php" class="block-20" style="background-image: url('assets/images/image_2.jpg');">
              </a>
              <div class="text d-flex py-4">
                <div class="meta mb-3">
                  <div><a href="#">Sep. 20, 2018</a></div>
                  <div><a href="#">Admin</a></div>
                  <div><a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a></div>
                </div>
                <div class="desc pl-3">
	                <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about the blind texts</a></h3>
	              </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 ftco-animate">
            <div class="blog-entry" data-aos-delay="200">
              <a href="blog-single.php" class="block-20" style="background-image: url('assets/images/image_3.jpg');">
              </a>
              <div class="text d-flex py-4">
                <div class="meta mb-3">
                  <div><a href="#">Sep. 20, 2018</a></div>
                  <div><a href="#">Admin</a></div>
                  <div><a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a></div>
                </div>
                <div class="desc pl-3">
	                <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about the blind texts</a></h3>
	              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
		
		<section class="ftco-quote">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-6 pr-md-5 aside-stretch py-5 choose">
    				<div class="heading-section heading-section-white mb-5 ftco-animate">
	            <h2 class="mb-2">DentaCare Procedure &amp; High Quality Services</h2>
	          </div>
	          <div class="ftco-animate">
	          	<p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar. Because there were thousands of bad Commas, wild Question Marks and devious Semikoli</p>
	          	<ul class="un-styled my-5">
	          		<li><span class="icon-check"></span>Consectetur adipisicing elit</li>
	          		<li><span class="icon-check"></span>Adipisci repellat accusamus</li>
	          		<li><span class="icon-check"></span>Tempore reprehenderit vitae</li>
	          	</ul>
	          </div>
    			</div>
    			<div class="col-md-6 py-5 pl-md-5">
    				<div class="heading-section mb-5 ftco-animate">
	            <h2 class="mb-2">Get a Free Quote</h2>
	          </div>
	          <form action="#" class="ftco-animate">
	          	<div class="row">
	          		<div class="col-md-6">
		              <div class="form-group">
		                <input type="text" class="form-control" placeholder="Full Name">
		              </div>
	              </div>
	              <div class="col-md-6">
		              <div class="form-group">
		                <input type="text" class="form-control" placeholder="Email">
		              </div>
	              </div>
	              <div class="col-md-6">
	              	<div class="form-group">
		                <input type="text" class="form-control" placeholder="Phone">
		              </div>
		            </div>
	              <div class="col-md-6">
	              	<div class="form-group">
		                <input type="text" class="form-control" placeholder="Website">
		              </div>
		            </div>
		            <div class="col-md-12">
		              <div class="form-group">
		                <textarea name="" id="" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
		              </div>
		            </div>
		            <div class="col-md-12">
		              <div class="form-group">
		                <input type="submit" value="Get a Quote" class="btn btn-primary py-3 px-5">
		              </div>
	              </div>
              </div>
            </form>
    			</div>
    		</div>
    	</div>
    </section>
		
		<div id="map"></div>

    <footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-3">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">DentaCare.</h2>
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            </div>
            <ul class="ftco-footer-social list-unstyled float-md-left float-lft ">
              <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
              <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
              <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
            </ul>
          </div>
          <div class="col-md-2">
            <div class="ftco-footer-widget mb-4 ml-md-5">
              <h2 class="ftco-heading-2">Quick Links</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block">About</a></li>
                <li><a href="#" class="py-2 d-block">Features</a></li>
                <li><a href="#" class="py-2 d-block">Projects</a></li>
                <li><a href="#" class="py-2 d-block">Blog</a></li>
                <li><a href="#" class="py-2 d-block">Contact</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4 pr-md-4">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Recent Blog</h2>
              <div class="block-21 mb-4 d-flex">
                <a class="blog-img mr-4" style="background-image: url('assets/images/image_1.jpg');"></a>
                <div class="text">
                  <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about</a></h3>
                  <div class="meta">
                    <div><a href="#"><span class="icon-calendar"></span> Sept 15, 2018</a></div>
                    <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                    <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                  </div>
                </div>
              </div>
              <div class="block-21 mb-4 d-flex">
                <a class="blog-img mr-4" style="background-image: url('assets/images/image_2.jpg');"></a>
                <div class="text">
                  <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about</a></h3>
                  <div class="meta">
                    <div><a href="#"><span class="icon-calendar"></span> Sept 15, 2018</a></div>
                    <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                    <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Office</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@yourdomain.com</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

            <p>
              Copyright &copy;<script>document.write(new Date().getFullYear());</script>
              All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i>
              by <a href="https://colorlib.com" target="_blank">Colorlib</a>
            </p>
          </div>
        </div>
      </div>
    </footer>
    
  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen">
    <svg class="circular" width="48px" height="48px">
      <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
      <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/>
    </svg>
  </div>

  <!-- Modal -->

<div class="modal fade" id="modalRequest" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Đặt lịch khám</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="modalAppointmentForm" class="appointment-form">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <select name="department" class="form-control" required>
                  <option value="">Chọn dịch vụ</option>
                  <option value="Tẩy trắng răng">Tẩy trắng răng</option>
                  <option value="Cạo vôi răng">Cạo vôi răng</option>
                  <option value="Niềng răng">Niềng răng</option>
                  <option value="Cấy ghép Implant">Cấy ghép Implant</option>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Họ tên" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <input type="text" name="phone" class="form-control" placeholder="SĐT" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <input type="text" name="date" class="form-control appointment_date" placeholder="Ngày" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <input type="text" name="time" class="form-control appointment_time" placeholder="Giờ" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <textarea name="reason" class="form-control" rows="3" placeholder="Ghi chú"></textarea>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Đặt lịch</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


  <!-- JS -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/jquery-migrate-3.0.1.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/jquery.easing.1.3.js"></script>
  <script src="assets/js/jquery.waypoints.min.js"></script>
  <script src="assets/js/jquery.stellar.min.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>
  <script src="assets/js/jquery.magnific-popup.min.js"></script>
  <script src="assets/js/aos.js"></script>
  <script src="assets/js/jquery.animateNumber.min.js"></script>
  <script src="assets/js/bootstrap-datepicker.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.14.1/jquery.timepicker.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.14.1/jquery.timepicker.min.js"></script>  <script src="assets/js/scrollax.min.js"></script>

  <!-- Google Map (sẽ cảnh báo key nếu key không hợp lệ, nhưng không làm bể layout) -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="assets/js/google-map.js"></script>

  <script src="assets/js/main.js"></script>
  <!-- AJAX XỬ LÝ FORM -->
 <script>
$(document).ready(function() {
  // Datepicker + Timepicker
  $('.appointment_date').datepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
    todayHighlight: true,
    startDate: new Date()
  });
$('.appointment_time').timepicker({
    timeFormat: 'HH:mm',
    interval: 30,
    minTime: '08:00',
    maxTime: '19:00',
    defaultTime: '08:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
});
  // Xử lý cả 2 form
  $('#appointmentForm, #modalAppointmentForm').on('submit', function(e) {
    e.preventDefault();
    const formData = $(this).serialize();

    $.ajax({
      url: '../handle/appointment_process.php',
      method: 'POST',
      data: formData,
      dataType: 'json',
      success: function(res) {
        Swal.fire({
          icon: res.status === 'success' ? 'success' : 'error',
          title: res.status === 'success' ? 'Thành công!' : 'Lỗi!',
          text: res.message,
          timer: res.status === 'success' ? 3000 : null,
          showConfirmButton: res.status !== 'success'
        }).then(() => {
          if (res.status === 'success') {
            $(e.target)[0].reset();
            $('#modalRequest').modal('hide');
          }
        });
      },
      error: function() {
        Swal.fire('Lỗi', 'Không thể kết nối server.', 'error');
      }
    });
  });

  // Hiển thị thông báo từ session (nếu redirect)
  <?php if ($success): ?>
    Swal.fire('Thành công', '<?= addslashes($success) ?>', 'success');
  <?php elseif ($error): ?>
    Swal.fire('Lỗi', '<?= addslashes($error) ?>', 'error');
  <?php endif; ?>
});
</script>
    
</body>
</html>