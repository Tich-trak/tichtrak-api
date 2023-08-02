<x-mail::message>

# Dear {{$data['user']['name']}},

We are delighted to welcome you to TICHTRAK EdTech! Thank you for choosing our platform to enhance your educational journey.
We are excited to have you on board and look forward to supporting your growth and success.

To ensure the security of your account and to complete the registration process, we kindly request you to verify your email address.
Account verification is a crucial step to safeguard your personal information and guarantee the integrity of our platform.

Please follow the simple steps below to verify your email address:

1. Click on the verification link below.
2. You will be directed to a verification page.
3. Enter your login credentials (if prompted).
4. Once logged in, your email verification will be confirmed, and you will gain full access to TICHTRAK EdTech.

In case you encounter any issues during the verification process or have any questions,
please feel free to reach out to our support team at +2349032342093. We are here to assist you at every step.

As a registered user of TICHTRAK EdTech, you will gain access to a wide range of features and
resources that will empower your educational experience. Our platform offers:

- Personalized assessment tools to gauge your academic progress.
- A library of educational materials and resources to supplement your learning.
- Interactive exercises and quizzes to enhance your understanding of various subjects.
- Performance tracking and analytics to monitor your growth.

<x-mail::button :url="env('APP_URL') . '/api/v1/verify/' . $data['verification_token']" color="primary">
Verify Email
</x-mail::button>

# Button Not Working?? Try pasting the link below into your Browser

{{env('APP_URL') . '/api/v1/verify/' . $data['verification_token']}}

<x-mail::subcopy>
We are committed to providing a seamless and enriching educational journey for you. Your feedback and suggestions are invaluable to us,
so please don't hesitate to share your thoughts as you explore the platform.

Thank you again for choosing TICHTRAK EdTech. Together, we will unlock the door to your academic success.
</x-mail::subcopy>

Best regards,<br>
C.E.O Tichtrak
# {{ config('app.name') }}

</x-mail::message>
