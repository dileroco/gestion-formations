@extends('layouts.public')

@section('title', __('Contact Us'))

@section('content')
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
            <div class="space-y-8">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 tracking-tight leading-tight">
                    {{ __('Let\'s Start') }} <br>
                    <span class="text-indigo-600 underline text-3xl font-medium tracking-normal decoration-indigo-200 decoration-4 underline-offset-4">{{ __('A Conversation') }}</span>
                </h1>
                <p class="text-lg text-gray-600 leading-relaxed border-l-4 border-indigo-100 pl-6">
                    {{ __('Have a question about our trainings or need a custom solution? Our team is here to help you navigate your journey.') }}
                </p>

                <div class="space-y-4 pt-6 text-sm">
                    <div class="font-bold uppercase tracking-widest text-gray-400 text-[10px]">{{ __('Email') }}</div>
                    <div class="text-indigo-600 font-bold">support@gestionform.ma</div>
                </div>
            </div>

            <!-- Contact Form -->
            <div x-data="contactForm()" class="bg-white p-10 rounded-xl shadow-sm border border-gray-100 relative">
                <div x-show="success" 
                     class="absolute inset-0 bg-white/95 z-20 flex flex-col items-center justify-center text-center p-10 rounded-xl">
                    <div class="w-16 h-16 bg-green-50 text-green-600 rounded-full flex items-center justify-center mb-6 border border-green-100">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ __('Message Sent!') }}</h3>
                    <p class="text-gray-500 font-medium mb-8">{{ __('Thank you for reaching out. Our team will contact you shortly.') }}</p>
                    <button @click="success = false" class="px-8 py-3 bg-indigo-600 text-white rounded-lg font-bold text-sm">{{ __('Send Another') }}</button>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Full Name') }}</label>
                            <input type="text" x-model="form.name" required class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-transparent focus:bg-white focus:border-indigo-400 transition text-sm font-medium text-gray-800" placeholder="John Doe">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Email Address') }}</label>
                            <input type="email" x-model="form.email" required class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-transparent focus:bg-white focus:border-indigo-400 transition text-sm font-medium text-gray-800" placeholder="john@example.com">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Phone (Optional)') }}</label>
                            <input type="text" x-model="form.phone" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-transparent focus:bg-white focus:border-indigo-400 transition text-sm font-medium text-gray-800" placeholder="+212 ...">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Subject') }}</label>
                            <input type="text" x-model="form.subject" required class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-transparent focus:bg-white focus:border-indigo-400 transition text-sm font-medium text-gray-800" placeholder="{{ __('How can we help?') }}">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">{{ __('Message') }}</label>
                        <textarea x-model="form.message" required rows="5" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-transparent focus:bg-white focus:border-indigo-400 transition text-sm font-medium text-gray-800 leading-relaxed" placeholder="{{ __('Tell us more...') }}"></textarea>
                    </div>

                    <button type="submit" 
                            :disabled="loading"
                            class="w-full py-4 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition text-sm uppercase tracking-widest disabled:opacity-50">
                        <span x-show="!loading">{{ __('Send Message') }}</span>
                        <span x-show="loading" class="flex items-center justify-center">
                            <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function contactForm() {
        return {
            form: {
                name: '', email: '', phone: '', subject: '', message: ''
            },
            loading: false,
            success: false,
            submit() {
                this.loading = true;
                fetch('{{ route(active_locale().".contact.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(this.form)
                })
                .then(response => response.json())
                .then(data => {
                    this.loading = false;
                    this.success = true;
                    this.form = { name: '', email: '', phone: '', subject: '', message: '' };
                })
                .catch(error => {
                    this.loading = false;
                    alert('An error occurred. Please try again.');
                });
            }
        }
    }
</script>
@endpush
@endsection
