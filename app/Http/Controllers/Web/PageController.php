<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function about()
    {
        return view('web.pages.about');
    }
    
    public function contact()
    {
        return view('web.pages.contact');
    }
    
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);
        
        // Here you would typically send an email with the contact form data
        // For now, we'll just return a success message
        
        return back()->with('success', __('Your message has been sent successfully. We will contact you soon!'));
    }
    
    public function faq()
    {
        $faqs = [
            [
                'question' => __('What are your working hours?'),
                'answer' => __('We are open every day from 10:00 AM to 11:00 PM.')
            ],
            [
                'question' => __('Do you offer delivery?'),
                'answer' => __('Yes, we offer delivery within a 10km radius. Delivery is free for orders over 200 EGP.')
            ],
            [
                'question' => __('Can I make a reservation?'),
                'answer' => __('Yes, you can make a reservation online through our website or by calling us at +123 456 7890.')
            ],
            [
                'question' => __('Do you cater for special dietary requirements?'),
                'answer' => __('Yes, we offer vegetarian and gluten-free options. Please specify your dietary requirements when placing your order.')
            ],
            [
                'question' => __('How can I pay?'),
                'answer' => __('We accept cash on delivery, credit/debit cards, and mobile payments.')
            ],
            [
                'question' => __('Can I modify my order after placing it?'),
                'answer' => __('You can modify your order within 5 minutes of placing it by calling our customer service.')
            ],
        ];
        
        return view('web.pages.faq', compact('faqs'));
    }
}
