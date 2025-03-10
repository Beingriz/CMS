@extends('user\user_account\user_account_master')
@section('UserAccount')
<div class="page-content" style="margin-top: 15px">
    <div class="container my-5">
        <div class="row g-4">
            <h2 class="text-center fw-bold text-primary mb-4">🌟 Stay Connected with Us & Explore More! 🌟</h2>
            <p class="text-center text-muted mb-4">Follow us, join our community, watch our latest videos, and stay updated! 🚀</p>

            <!-- 1️⃣ Social Media Follow Section -->
            <div class="col-lg-6">
                <div class="card border-0 shadow rounded">
                    <div class="card-body text-center">
                        <h4 class="card-title text-primary fw-bold">Follow Us on Social Media</h4>
                        <p class="text-muted">Stay connected for the latest updates! 🚀</p>
                        <div class="d-flex justify-content-center gap-3 mt-3">
                            <a href="https://facebook.com/yourpage" target="_blank" class="btn btn-primary btn-lg rounded-circle social-btn">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://twitter.com/yourpage" target="_blank" class="btn btn-info btn-lg rounded-circle social-btn text-white">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="https://instagram.com/my_digital_cyber"  class="btn btn-danger btn-lg rounded-circle social-btn">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="https://linkedin.com/in/yourpage" target="_blank" class="btn btn-dark btn-lg rounded-circle social-btn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2️⃣ WhatsApp Channel -->
            <div class="col-lg-6">
                <div class="card border-0 shadow rounded">
                    <div class="card-body text-center">
                        <h4 class="card-title text-success fw-bold">Join Our WhatsApp Channel</h4>
                        <p class="text-muted">Get exclusive updates instantly! 📢</p>
                        <a href="https://whatsapp.com/channel/0029VayUP5m6WaKnD8rt8Q3Q" target="_blank" class="btn btn-success btn-lg">
                            <i class="bi bi-whatsapp"></i> Join Now
                        </a>
                    </div>
                </div>
            </div>

            <!-- 3️⃣ YouTube Video Playlist Slider -->
            <div class="col-lg-6">
                <div class="card border-0 shadow rounded">
                    <div class="card-body text-center">
                        <h4 class="card-title text-primary fw-bold">Watch Our YouTube Videos</h4>
                        <p class="text-muted">Explore our latest content 🎥</p>

                        <div id="videoCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <!-- Video 1 -->
                                <div class="carousel-item active">
                                    <div class="ratio ratio-16x9 rounded">
                                        <iframe src="https://www.youtube.com/embed/VIDEO_ID_1" allowfullscreen></iframe>
                                    </div>
                                </div>
                                <!-- Video 2 -->
                                <div class="carousel-item">
                                    <div class="ratio ratio-16x9 rounded">
                                        <iframe src="https://www.youtube.com/embed/VIDEO_ID_2" allowfullscreen></iframe>
                                    </div>
                                </div>
                                <!-- Video 3 -->
                                <div class="carousel-item">
                                    <div class="ratio ratio-16x9 rounded">
                                        <iframe src="https://www.youtube.com/embed/VIDEO_ID_3" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>

                            <!-- Carousel Controls -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#videoCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#videoCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4️⃣ Google Maps Location -->
            <div class="col-lg-6">
                <div class="card border-0 shadow rounded">
                    <div class="card-body text-center">
                        <h4 class="card-title text-primary fw-bold">Find Our Location</h4>
                        <p class="text-muted">Visit us at our office 📍</p>
                        <div class="ratio ratio-16x9 rounded overflow-hidden">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3888.41654032766!2d77.4717837757228!3d12.945176615455733!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae3f78bb47f74d%3A0xe8ade16413605766!2sDigital%20Cyber%20Pvt%20Ltd!5e0!3m2!1sen!2sin!4v1741640456014!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5️⃣ Join WhatsApp Group -->
            <div class="col-lg-6">
                <div class="card border-0 shadow rounded">
                    <div class="card-body text-center">
                        <h4 class="card-title text-success fw-bold">Join Our WhatsApp Group</h4>
                        <p class="text-muted">Be part of our community! 👥</p>
                        <a href="https://chat.whatsapp.com/H966U4IPYFJBNxELSkBSOR" target="_blank" class="btn btn-success btn-lg">
                            <i class="bi bi-people-fill"></i> Join Group
                        </a>
                    </div>
                </div>
            </div>

            <!-- 6️⃣ Google Review Section -->
            <div class="col-lg-6">
                <div class="card border-0 shadow rounded">
                    <div class="card-body text-center">
                        <h4 class="card-title text-primary fw-bold">Leave Us a Review on Google</h4>
                        <p class="text-muted">We appreciate your feedback! ⭐⭐⭐⭐⭐</p>
                        <a href="https://g.page/r/Ca3UZBoMZe39EAI/review" target="_blank" class="btn btn-warning btn-lg px-4 fw-bold">
                            <i class="bi bi-star-fill"></i> Give a Review
                        </a>
                    </div>
                </div>
            </div>
            <h4 class="text-center fw-bold text-secondary mt-5">🙏 Thank You for Connecting with Us!</h4>
            <p class="text-center text-muted">Digital Cyber | The Power to Empower 🚀</p>

        </div>
    </div>

    <!-- Floating WhatsApp Chat Button -->
    <a href="https://wa.me/yourwhatsappnumber" target="_blank" class="whatsapp-float">
        <i class="bi bi-whatsapp"></i>
    </a>

    <!-- Custom CSS -->
    <style>
        .whatsapp-float {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #25D366;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease-in-out;
            z-index: 1000;
        }
        .whatsapp-float:hover {
            transform: scale(1.1);
        }
    </style>



</div>

@endsection
