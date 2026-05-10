@extends('layouts.public')
@section('title', 'Contact Us')

@push('styles')
<style>
.contact-page { max-width: 1000px; margin: 0 auto; padding: 48px 24px; }
.page-head { text-align: center; margin-bottom: 36px; }
.page-head h1 { font-size: 32px; font-weight: 800; color: #0f172a; margin-bottom: 8px; }
.page-head p { font-size: 16px; color: #64748b; }

.contact-grid { display: grid; grid-template-columns: 1fr 320px; gap: 20px; }

.form-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 28px; }
.form-card h2 { font-size: 17px; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
.form-card > p { font-size: 14px; color: #64748b; margin-bottom: 22px; }

.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.form-group { margin-bottom: 16px; }
.form-group label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 5px; }
.form-group input, .form-group textarea {
    width: 100%; background: #f8fafc; border: 1px solid #d1d5db; border-radius: 8px;
    padding: 10px 13px; color: #1e293b; font-size: 14px; font-family: 'Inter',sans-serif;
    outline: none; transition: border 0.15s;
}
.form-group input:focus, .form-group textarea:focus { border-color: #6366f1; background: #fff; box-shadow: 0 0 0 3px rgba(99,102,241,0.08); }
.form-group input::placeholder, .form-group textarea::placeholder { color: #9ca3af; }
.form-group textarea { resize: vertical; min-height: 110px; }

.btn-send { width: 100%; background: #6366f1; color: #fff; border: none; padding: 12px; border-radius: 8px; font-size: 15px; font-weight: 700; cursor: pointer; font-family: 'Inter',sans-serif; transition: background 0.15s; display: flex; align-items: center; justify-content: center; gap: 8px; }
.btn-send:hover { background: #4f46e5; }

.info-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 24px; }
.info-card h3 { font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 18px; }
.info-item { display: flex; align-items: flex-start; gap: 12px; padding: 12px 0; border-bottom: 1px solid #f1f5f9; }
.info-item:last-of-type { border-bottom: none; }
.info-icon { width: 36px; height: 36px; background: #eef2ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6366f1; font-size: 14px; flex-shrink: 0; }
.info-text strong { display: block; font-size: 13px; font-weight: 600; color: #1e293b; margin-bottom: 2px; }
.info-text span { font-size: 13px; color: #64748b; line-height: 1.5; }

.social-row { display: flex; gap: 8px; margin-top: 18px; padding-top: 16px; border-top: 1px solid #f1f5f9; }
.social-btn-sm { width: 36px; height: 36px; border-radius: 8px; background: #f1f5f9; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: #64748b; text-decoration: none; font-size: 14px; transition: all 0.15s; }
.social-btn-sm:hover { background: #eef2ff; border-color: #6366f1; color: #6366f1; }

@media(max-width:800px) {
    .contact-grid { grid-template-columns: 1fr; }
    .form-row { grid-template-columns: 1fr; }
    .page-head h1 { font-size: 24px; }
}
</style>
@endpush

@section('content')
<div class="contact-page">

    <div class="page-head">
        <h1>Get in Touch</h1>
        <p>Have a question? We'd love to hear from you. We respond within 24 hours.</p>
    </div>

    <div class="contact-grid">
        <div class="form-card">
            <h2>Send Us a Message</h2>
            <p>Fill out the form and our team will get back to you shortly.</p>

            <form action="#" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label>Your Name</label>
                        <input type="text" name="name" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" placeholder="john@example.com" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" name="subject" placeholder="How can we help?">
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" placeholder="Write your message here..." required></textarea>
                </div>
                <button type="submit" class="btn-send"><i class="fas fa-paper-plane"></i> Send Message</button>
            </form>
        </div>

        <div class="info-card">
            <h3>Contact Information</h3>
            <div class="info-item">
                <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div class="info-text"><strong>Address</strong><span>1234 Street, Mumbai,<br>Maharashtra, India</span></div>
            </div>
            <div class="info-item">
                <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
                <div class="info-text"><strong>Phone</strong><span>+91 123 456 7890</span></div>
            </div>
            <div class="info-item">
                <div class="info-icon"><i class="fas fa-envelope"></i></div>
                <div class="info-text"><strong>Email</strong><span>support@jobportalpro.com</span></div>
            </div>
            <div class="info-item">
                <div class="info-icon"><i class="fas fa-clock"></i></div>
                <div class="info-text"><strong>Working Hours</strong><span>Mon – Fri: 9AM – 6PM</span></div>
            </div>
            <div class="social-row">
                <a href="#" class="social-btn-sm" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-btn-sm" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-btn-sm" title="Twitter"><i class="fab fa-x-twitter"></i></a>
                <a href="#" class="social-btn-sm" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>

</div>
@endsection
