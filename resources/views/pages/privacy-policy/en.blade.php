@section('title', 'Privacy Policy')
@section('meta_description', 'Privacy Policy for ' . config('site.name'))

@extends('layouts.default')

@section('content')
    <div class="page-header">
        <h1>Privacy Policy</h1>
    </div>
    <p>This privacy policy discloses the privacy practices for {!! env('APP_URL') !!}. This privacy policy applies solely to information collected by this web site. It will notify you of the following:</p>
    <ol>
        <li>What personally identifiable information is collected from you through the web site, how it is used and with whom it may be shared.</li>
        <li>What choices are available to you regarding the use of your data?</li>
        <li>The security procedures in place to protect the misuse of your information.</li>
        <li>How you can correct any inaccuracies in the information.</li>
    </ol>

    <h2>Information Collection, Use, and Sharing</h2>
    <p>We retain full rights of the information collected on this site. We have access to/collect and store information that you voluntarily give us via email/google/Facebook or other direct contact from you.</p>
    <p>We will use your information to respond to you, regarding the reason you contacted us. Again, we will retain the rights your information and use it anonymously with any trusted third party outside of our organization.</p>
    <p>Unless you ask us not to, we may contact you via email in the future to tell you about specials, new products or services, or changes to this privacy policy.</p>

    <h2>Your Access to and Control Over Information</h2>
    <p>You may opt out of any future contacts from us at any time, given a 30 days’ notice. You can do the following at any time by contacting us via the email address or phone number given on our website:</p>
    <ul>
        <li>See what data we have about you, if any.</li>
        <li>Change/correct any data we have about you.</li>
        <li>Express any concern you have about our use of your data.</li>
    </ul>

    <h2>Security</h2>
    <p>We take precautions to protect your information. When you submit sensitive information via the website, your
        information is protected both online and offline.</p>
    <p>Wherever we collect sensitive information (such as credit card data), that information is encrypted and
        transmitted to us in a secure way. You can verify this by looking for a closed lock icon at the bottom of your
        web browser, or looking for "https" at the beginning of the address of the web page.</p>
    <p>While we use encryption to protect sensitive information transmitted online, we also protect your information
        offline. Only employees who need the information to perform a specific job (for example, billing or customer
        service) are granted access to personally identifiable information. The computers/servers in which we store
        personally identifiable information are kept in a secure environment.</p>

    <h2>Updates</h2>
    <p>Updates
        Our Privacy Policy may change from time to time and all updates will be posted on this page.</p>


    <h2>Orders</h2>
    <p>We request information from you on our order form. To buy from us, you must provide contact information (like
        name and shipping address) and financial information (like credit card number, expiration date). This
        information is used for billing purposes and to fill your orders. If we have trouble processing an order, we'll
        use this information to contact you.</p>

    <h2>Sharing</h2>
    <p>We share aggregated demographic information with our partners and advertisers. This is not linked to any personal information that can identify any individual person. We partner with another party to provide specific services. When the user signs up for these services, we will share names, or other contact information that is necessary for the third party to provide these services. These parties are not allowed to use personally identifiable information except for the purpose of providing these services. </p>

    <h2>Survey & Contests</h2>
    <p>From time-to-time our site requests information via surveys or contests. Participation in these surveys or
        contests is completely voluntary and you may choose whether or not to participate and therefore disclose this
        information. Information requested may include contact information (such as name and shipping address), and
        demographic information (such as zip code, age level). Contact information will be used to notify the winners
        and award prizes. Survey information will be used for purposes of monitoring or improving the use and
        satisfaction of this site.</p>


    <p>If you feel that we are not abiding by this privacy policy, you should contact us immediately via email
        {{ config('site.email.support') }}.</p>

    <p>Last updated: 5th April 2016</p>
@endsection