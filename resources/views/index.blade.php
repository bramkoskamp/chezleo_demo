@extends('layout')

@section('content')

@if(session('success'))
<div id="success-popup" style="position: fixed; top: 10%; left: 50%; transform: translate(-50%, -50%); background-color: #1e7f0c; color: white; padding: 1rem; border-radius: 0.375rem; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); z-index: 1000; text-align: center;">
    {{ session('success') }}
</div>
@elseif(session('error'))
<div id="error-popup" style="position: fixed; top: 10%; left: 50%; transform: translate(-50%, -50%); background-color: #e53403; color: white; padding: 1rem; border-radius: 0.375rem; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); z-index: 1000; text-align: center;">
    {{ session('error') }}
</div>
@endif

<div class="  py-5 bg-dark hero-header mb-5">
    <div class="container my-5 py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="display-3 text-white animated slideInLeft">Geniet van Onze<br>heerlijke maaltijden</h1>
                <p class="text-white animated slideInLeft mb-4 pb-2">Ontdek de smaak van puur genieten. Onze gerechten worden met zorg bereid uit verse, lokale ingrediënten. Of je nu komt voor een diner of een lunch, elke maaltijd is een culinaire beleving die je niet wilt missen!</p>
                <a href="{{ route('reservering') }}" class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideInLeft">Reserveer nu</a>
            </div>
            <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                <img class="img-fluid" src="img/hero.png" alt="">
            </div>
        </div>
    </div>
</div>
</div>
<!-- Navbar & Hero End -->


<!-- Service Start -->
<div class="  py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item rounded pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-user-tie text-primary mb-4"></i>
                        <h5>Meesterkok</h5>
                        <p>Onze meesterkok maakt van elk gerecht een culinaire verrassing.</p>
                        </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item rounded pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-utensils text-primary mb-4"></i>
                        <h5>Goede kwaliteit eten</h5>
                        <p>Geniet van versbereide gerechten met pure, lokale ingrediënten en een passie voor smaak.</p>
                        </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="service-item rounded pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-cart-plus text-primary mb-4"></i>
                        <h5>Online Bestellen</h5>
                        <p>Bestel eenvoudig online en geniet van onze heerlijke gerechten thuis.</p>
                        </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="service-item rounded pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-headset text-primary mb-4"></i>
                        <h5>24/7 Service</h5>
                        <p>Voor vragen of meldingen neem contact met ons op.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Service End -->


<!-- About Start -->
<div class="  py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6 text-start">
                        <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.1s"
                            src="img/about-1.jpg">
                    </div>
                    <div class="col-6 text-start">
                        <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.3s"
                            src="img/about-2.jpg" style="margin-top: 25%;">
                    </div>
                    <div class="col-6 text-end">
                        <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.5s"
                            src="img/about-3.jpg">
                    </div>
                    <div class="col-6 text-end">
                        <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.7s"
                            src="img/about-4.jpg">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h5 class="section-title ff-secondary text-start text-primary fw-normal">Over ons</h5>
                <h1 class="mb-4">Welkom bij <i class="fa fa-utensils text-primary me-2"></i> Chez Leo</h1>
                <p class="mb-4">Bij Chez Leo streven we ernaar om u een onvergetelijke culinaire ervaring te bieden.
                     Onze meesterkoks bereiden dagelijks verse, smakelijke gerechten met de hoogste kwaliteit ingrediënten.</p>
                <p class="mb-4">Hier kunt u genieten van een breed scala aan gerechten, van klassieke gerechten tot eigentijdse creaties..</p>
                <div class="row g-4 mb-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                            <h1 class="flex-shrink-0 display-5 text-primary mb-0" data-toggle="counter-up">15
                            </h1>
                            <div class="ps-4">
                                <p class="mb-0">Jaar</p>
                                <h6 class="text-uppercase mb-0">Ervaring</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                            <h1 class="flex-shrink-0 display-5 text-primary mb-0" data-toggle="counter-up">50
                            </h1>
                            <div class="ps-4">
                                <p class="mb-0">Populaire</p>
                                <h6 class="text-uppercase mb-0">Meesterkoks</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="btn btn-primary py-3 px-5 mt-2" href="">Lees meer</a>
            </div>
        </div>
    </div>
</div>
<!-- About End -->


<!-- Menu Start -->
<div class="py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">Menu</h5>
            <h1 class="mb-5">Ons Menu</h1>
        </div>
        <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
            <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                <li class="nav-item">
                    <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active" data-bs-toggle="pill"
                        href="#tab-1">
                        <i class="fa fa-coffee fa-2x text-primary"></i>
                        <div class="ps-3">
                            <small class="text-body">Heerlijk</small>
                            <h6 class="mt-n1 mb-0">Drinken</h6>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="d-flex align-items-center text-start mx-3 pb-3" data-bs-toggle="pill"
                        href="#tab-2">
                        <i class="fa fa-hamburger fa-2x text-primary"></i>
                        <div class="ps-3">
                            <small class="text-body">Speciale</small>
                            <h6 class="mt-n1 mb-0">Lunch</h6>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="d-flex align-items-center text-start mx-3 me-0 pb-3" data-bs-toggle="pill"
                        href="#tab-3">
                        <i class="fa fa-utensils fa-2x text-primary"></i>
                        <div class="ps-3">
                            <small class="text-body">Geweldig</small>
                            <h6 class="mt-n1 mb-0">Avondeten</h6>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="d-flex align-items-center text-start mx-3 me-0 pb-3" data-bs-toggle="pill"
                        href="#tab-4">
                        <i class="fa fa-utensils fa-2x text-primary"></i>
                        <div class="ps-3">
                            <small class="text-body">Wonderbaarlijke</small>
                            <h6 class="mt-n1 mb-0">Toetjes</h6>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                        @foreach($menu as $menu_item)
                        @if($menu_item->category == 'Drank')
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center">
                                <div class="w-100 d-flex flex-column text-start ps-4">
                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                        <span>{{$menu_item->name}}</span>
                                        <span class="text-primary">€{{ number_format($menu_item->price, 2) }}</span>
                                    </h5>
                                    <small class="fst-italic">{{$menu_item->description}}</small>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div id="tab-2" class="tab-pane fade show p-0">
                    <div class="row g-4">
                        @foreach($menu as $menu_item)
                        @if($menu_item->category == 'Lunch')
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center">
                                <div class="w-100 d-flex flex-column text-start ps-4">
                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                        <span>{{$menu_item->name}}</span>
                                        <span class="text-primary">€{{ number_format($menu_item->price, 2) }}</span>
                                    </h5>
                                    <small class="fst-italic">{{$menu_item->description}}</small>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div id="tab-3" class="tab-pane fade show p-0">
                    <div class="row g-4">
                        @foreach($menu as $menu_item)
                        @if($menu_item->category == 'Diner')
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center">
                                <div class="w-100 d-flex flex-column text-start ps-4">
                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                        <span>{{$menu_item->name}}</span>
                                        <span class="text-primary">€{{ number_format($menu_item->price, 2) }}</span>
                                    </h5>
                                    <small class="fst-italic">{{$menu_item->description}}</small>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div id="tab-4" class="tab-pane fade show p-0">
                    <div class="row g-4">
                        @foreach($menu as $menu_item)
                        @if($menu_item->category == 'Dessert')
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center">
                                <div class="w-100 d-flex flex-column text-start ps-4">
                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                        <span>{{$menu_item->name}}</span>
                                        <span class="text-primary">€{{ number_format($menu_item->price, 2) }}</span>
                                    </h5>
                                    <small class="fst-italic">{{$menu_item->description}}</small>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Menu End -->

<!-- Reservation Start -->
<div class="  py-5 px-0 wow fadeInUp" data-wow-delay="0.1s">
    <div class="row g-0">
        <div class="col-md-6">
            <div class="video">
                <button type="button" class="btn-play" data-bs-toggle="modal"
                    data-src="{{'https://www.youtube.com/embed/DWRcNpR6Kdc'}}" data-bs-target="#videoModal">
                    <span></span>
                </button>
            </div>
        </div>
        <div class="col-md-6 bg-dark d-flex align-items-center">
    <div class="p-5 wow fadeInUp" data-wow-delay="0.2s">
        <h5 class="section-title ff-secondary text-start text-primary fw-normal">Contact</h5>
        <h1 class="text-white mb-4">Neem contact met ons op</h1>
        <div class="text-white">
            <p class="mb-2">
                <i class="fa fa-envelope me-2"></i>
                <strong>Email:</strong> chezleo@gmail.com
            </p>
            <p class="mb-2">
                <i class="fa fa-phone-alt me-2"></i>
                <strong>Telefoon:</strong> +31 6 22909915
            </p>
            <p class="mb-2">
                <i class="fa fa-map-marker-alt me-2"></i>
                <strong>Adres:</strong> Straatnaam 123, 1234 AB Stad
            </p>
        </div>
        <!-- <div class="col-12 mt-4">
            <a href="mailto:chezleo@gmail.com" class="btn btn-primary w-100 py-3">Stuur een e-mail</a>
        </div> -->
    </div>
</div>


<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Youtube Video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- 16:9 aspect ratio -->
                <div class="ratio ratio-16x9">
                    <iframe class="embed-responsive-item" src="" id="video" allowfullscreen
                        allowscriptaccess="always" allow="autoplay"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Reservation Start -->


<!-- Team Start -->
<!-- <div class="  pt-5 pb-3">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Team Members</h5>
                    <h1 class="mb-5">Our Master Chefs</h1>
                </div>
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item text-center rounded overflow-hidden">
                            <div class="rounded-circle overflow-hidden m-4">
                                <img class="img-fluid" src="img/team-1.jpg" alt="">
                            </div>
                            <h5 class="mb-0">Full Name</h5>
                            <small>Designation</small>
                            <div class="d-flex justify-content-center mt-3">
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="team-item text-center rounded overflow-hidden">
                            <div class="rounded-circle overflow-hidden m-4">
                                <img class="img-fluid" src="img/team-2.jpg" alt="">
                            </div>
                            <h5 class="mb-0">Full Name</h5>
                            <small>Designation</small>
                            <div class="d-flex justify-content-center mt-3">
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="team-item text-center rounded overflow-hidden">
                            <div class="rounded-circle overflow-hidden m-4">
                                <img class="img-fluid" src="img/team-3.jpg" alt="">
                            </div>
                            <h5 class="mb-0">Full Name</h5>
                            <small>Designation</small>
                            <div class="d-flex justify-content-center mt-3">
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                        <div class="team-item text-center rounded overflow-hidden">
                            <div class="rounded-circle overflow-hidden m-4">
                                <img class="img-fluid" src="img/team-4.jpg" alt="">
                            </div>
                            <h5 class="mb-0">Full Name</h5>
                            <small>Designation</small>
                            <div class="d-flex justify-content-center mt-3">
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
<!-- Team End -->


<!-- Testimonial Start -->
<div class="  py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="text-center">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">Reviews</h5>
            <h1 class="mb-5">Reviews van bezoekers!!!</h1>
        </div>
        <div class="owl-carousel testimonial-carousel">
            @foreach($reviews->take(4) as $review)
            <div class="testimonial-item bg-transparent border rounded p-4">
                <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                <h5 class="mb-1">{{$review->name}} zei:</h5>
                <p>{{$review->review_details}}</p>
                @for($i = 0; $i < $review->rating; $i++)
                    <i class="bi bi-star-fill text-yellow-400"></i>
                    @endfor
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Testimonial End -->

<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>

@endsection

<script>
    // Laat de melding na 5 seconden verdwijnen
    document.addEventListener('DOMContentLoaded', function() {
        const popup = document.getElementById('success-popup');
        const errorPopup = document.getElementById('error-popup');
        if (popup) {
            setTimeout(() => {
                popup.style.transition = 'opacity 0.5s ease';
                popup.style.opacity = '0';
                setTimeout(() => popup.remove(), 500);
            }, 5000);
        } else if(errorPopup) {
            setTimeout(() => {
                errorPopup.style.transition = 'opacity 0.5s ease';
                errorPopup.style.opacity = '0';
                setTimeout(() => errorPopup.remove(), 500);
            }, 5000);
        }
    });
</script>