@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h3 class="card-title mb-0">Help & Support</h3>
                </div>
                <div class="card-body">
                    <!-- Contact Support Section -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-envelope fa-3x text-primary mb-3"></i>
                                    <h5>Email Support</h5>
                                    <p class="mb-0">{{ $support['email'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-phone-alt fa-3x text-success mb-3"></i>
                                    <h5>Phone Support</h5>
                                    <p class="mb-0">{{ $support['phone'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-clock fa-3x text-info mb-3"></i>
                                    <h5>Working Hours</h5>
                                    <p class="mb-0">{{ $support['hours'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQs Section -->
                    <div class="row">
                        <div class="col-12">
                            <h4 class="mb-4">Frequently Asked Questions</h4>
                            <div class="accordion" id="faqAccordion">
                                @foreach($faqs as $index => $faq)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $index }}">
                                            <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" 
                                                    type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#collapse{{ $index }}" 
                                                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                                                    aria-controls="collapse{{ $index }}">
                                                {{ $faq['question'] }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $index }}" 
                                             class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                                             aria-labelledby="heading{{ $index }}" 
                                             data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                {{ $faq['answer'] }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Additional Resources -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <h4 class="mb-4">Additional Resources</h4>
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <i class="fas fa-book text-primary me-2"></i>
                                                User Guide
                                            </h5>
                                            <p class="card-text">Comprehensive guide on how to use the PayRoll system effectively.</p>
                                            <a href="#" class="btn btn-outline-primary">Read Guide</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <i class="fas fa-video text-success me-2"></i>
                                                Video Tutorials
                                            </h5>
                                            <p class="card-text">Step-by-step video guides for common tasks and procedures.</p>
                                            <a href="#" class="btn btn-outline-success">Watch Videos</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <i class="fas fa-file-alt text-info me-2"></i>
                                                Documentation
                                            </h5>
                                            <p class="card-text">Detailed documentation covering all features and functionalities.</p>
                                            <a href="#" class="btn btn-outline-info">View Docs</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 