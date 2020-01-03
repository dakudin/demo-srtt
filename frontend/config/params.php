<?php
$domainName = 'https://sortit.com';
return [
    'adminEmail' => 'dakudin@gmail.com',
    'domainName' => $domainName,
    'domain' => 'sortit.com',
    'supportEmail' => 'support@sortit.com',
    'user.rememberMeDuration' => 30 * 24 * 60, // one month
    'og_title' => ['property' => 'og:title', 'content' => 'The Quote Engine'],
    'og_description' => ['property' => 'og:description', 'content' => 'Whatever you want, we`ll sort it. Your free online personal assistant.'],
    'og_url' => ['property' => 'og:url', 'content' => $domainName],
    'og_image' => ['property' => 'og:image', 'content' => $domainName .'/images/campaign/sortit_fb.png'],
    'og_type' => ['property' => 'og:type', 'content' => 'website'],
    'og_locale' => ['property' => 'og:locale', 'content' => 'en_GB'],
    'fb_app_id' => ['property' => 'fb:app_id', 'content' => '2076627205736800'],
];
