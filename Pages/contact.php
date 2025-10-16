<?php include '../includes/header.php'; ?>
<div class="contact-container"> <!-- Unique class for Contact page -->
    <h2>Contact Us</h2>
    <p>Reach out to us for any questions or support. We're here to help!</p>

    <div class="contact-details">
        <h3>Our Contact Information</h3>
        <ul>
            <li><strong>Email:</strong> support@mentalhealthsystem.com</li>
            <li><strong>Phone:</strong> +1 (555) 123-4567</li>
            <li><strong>Address:</strong> 123 Wellness Street, Mindful City, MH 54321</li>
        </ul>
    </div>

    <div class="contact-form">
        <h3>Send Us a Message</h3>
        <form action="contact_process.php" method="POST">
            <label for="name">Your Name</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Your Email</label>
            <input type="email" id="email" name="email" required>

            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject" required>

            <label for="message">Your Message</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit" class="btn">Send Message</button>
        </form>
    </div>

    <div class="faq-section">
        <h3>Frequently Asked Questions</h3>
        <div class="faq-item">
            <h4>How can I book an appointment?</h4>
            <p>You can book an appointment by visiting our "Book an Appointment" page and following the simple steps to select a therapist and schedule a time.</p>
        </div>
        <div class="faq-item">
            <h4>How soon can I expect a response?</h4>
            <p>Our team aims to respond to all inquiries within 24-48 hours.</p>
        </div>
        <div class="faq-item">
            <h4>Can I cancel or reschedule an appointment?</h4>
            <p>Yes, you can manage your appointments through your account dashboard on our website.</p>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?> 