<x-mail::message>

# Hello {{$data['user']['name']}},

Thank you for choosing to partner with our EdTech platform to evaluate education performance. We are thrilled to have your esteemed
institution on board! To proceed with the account setup and ensure the security of your information, we kindly request you to verify your email address.

Verification is a crucial step that helps us protect the integrity of our platform and ensures that only authorized users gain access
to the evaluation tools. Rest assured that your data privacy and security are of utmost importance to us, and we follow industry best practices to safeguard your information.

To verify your email address, please follow the simple steps below:

1. Click on the link below to be redirected to the verification page.
2. If the link is not clickable, please copy and paste it into your web browser's address bar.
3. You will be directed to the verification page, where you will find a button labeled "Verify Email." Click on it to complete the process.

Once your email is successfully verified, you will gain full access to our platform's powerful tools and features, enabling you
to assess and enhance education performance effectively. If you encounter any issues during the verification process or have any questions
about our platform, please don't hesitate to reach out to our dedicated support team at 09032342093. We are here to assist you every step of the way.

<x-mail::button :url="env('APP_URL') . '/api/v1/verify/' . $data['verification_token']" color="primary">
Verify Email
</x-mail::button>

# Button Not Working?? Try pasting the link below into your Browser

{{env('APP_URL') . '/api/v1/verify/' . $data['verification_token']}}

# Below is your Login Credentials

Email: {{$data['user']['email']}},<br>
password: {{ $data['password'] }}

<x-mail::subcopy>
We are excited about the opportunities our partnership brings and are confident that together, we can drive positive changes in education.
Your valuable feedback and insights will play a pivotal role in shaping the future of education for generations to come.
Thank you again for choosing our EdTech platform. We look forward to a successful and fruitful collaboration.
</x-mail::subcopy>

Best regards,<br>
C.E.O {{ config('app.name') }}

</x-mail::message>
