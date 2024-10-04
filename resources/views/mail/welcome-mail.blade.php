{{-- <x-mail::message>
# welcome {{$user}}

<x-mail::button :url="$url">
Button text
</x-mail::button>
 
 
Your welcome mail has been received!
<x-mail::table>
| Laravel       | Table         | Example       |
| ------------- | :-----------: | ------------: |
| Col 2 is      | Centered      | $10           |
| Col 3 is      | Right-Aligned | $20           |
</x-mail::table>
 
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
 --}}

 @component("mail::message")
 # Welcome {{$user}}

 @component('mail::button', ['url' => 'www.google.com'])
 Button Text
 @endcomponent

 @component('mail::panel')
 This is Mail Panel
 @endcomponent

 @component('mail::table')
| Laravel       | Table         | Example       |
| ------------- | :-----------: | ------------: |
| Col 2 is      | Centered      | $10           |
| Col 3 is      | Right-Aligned | $20           |
 @endcomponent

 @component('mail::subcopy')
 This is Mail Subcopy
 @endcomponent

Thanks,<br>
{{ config('app.name') }}

 @endcomponent
