@extends('layouts.app')


@section('content')
<div class="container ">
    <div class="card my-4 p-2 border-0 bg-light shadow-sm">
        <div class="card-body">

            @include('profile.profileBanner', ['object' => $thread])
            <div class="mt-3">
                <div>
                    <h1 class="card-title" id="thread-title-{{ $thread->id }}" data-full-content="{{ $thread->title }}">
                        {{ ($thread->title) }}
                    </h1>
                    <p id="thread-body-{{ $thread->id }}" data-full-content="{{ $thread->body }}">{{ $thread->body }}</p>
                    <a href="javascript:void(0)" id="translate-link-{{ $thread->id }}" onclick="translateThreadBody({{ $thread->id }})" class="text-primary">
                        @lang('messages.translate')
                    </a>
                </div>
                @if($thread->threads_image)
                <img class="rounded img-fluid my-2" src="{{ $thread->threads_image }}" alt="Thread Image" style="max-width: 20vw; height: auto;">
                @endif
            </div>
            @include('threads.vote.vote', ['object' => $thread, 'type' => 'thread'])
            
        </div>
    </div>


    @include('threads.comments.comments' , ['comments' => $thread -> comments])


</div>

<script>
async function translateThreadBody(threadId) {
    event.stopPropagation();

    const threadTitleElement = document.getElementById(`thread-title-${threadId}`);
    const threadBodyElement = document.getElementById(`thread-body-${threadId}`);
    const translateLinkElement = document.getElementById(`translate-link-${threadId}`);

    if (!translateLinkElement || !threadTitleElement || !threadBodyElement) {
        console.error('Translate link element not found.');
        return;
    }

    const originalBody = threadBodyElement.dataset.fullContent;
    const originalTitle = threadTitleElement.dataset.fullContent;
    var targetLocale = '{{ app()->getLocale() }}';  // set locale as target lang

    // naming convention, thought 'jp' was common but seems like ISO uses 'ja'
    if(targetLocale == 'jp'){
        targetLocale = 'ja';
    }
    
    console.log('Original Title:', originalTitle); // check the title being sent
    console.log('Original Text:', originalBody); // check the text being sent
    console.log('Target Locale:', targetLocale); // check target lang

    if (translateLinkElement.innerText === '{{ __('messages.translate') }}') {
        try {
            // set the API url and params
            const endpoint = '{{ config('services.azure_translator.endpoint') }}';
            const location = '{{ config('services.azure_translator.region') }}';
            const path = '/translate';
            const constructedUrl = endpoint + path;
            
            const params = {
                'api-version': '3.0',
                // 'from': 'en', // not required, uses auto detect
                'to': [targetLocale]
            };
            
            const headers = {
                'Ocp-Apim-Subscription-Key': '{{ config('services.azure_translator.key') }}',
                'Ocp-Apim-Subscription-Region': location,
                'Content-Type': 'application/json',
                'X-ClientTraceId': String(Math.floor(Math.random() * 1000000)) // untuk tracking aja buat debug & monitor
            };

            const body = [
                { 'text': originalTitle },
                { 'text': originalBody }
            ];
            
            // send POST req to azure translator API
            const response = await fetch(constructedUrl + '?' + new URLSearchParams(params), {
                method: 'POST',
                headers: headers,
                body: JSON.stringify(body)
            });

            // check if we get good response
            if (!response.ok) {
                console.error(`Error: ${response.status} - ${response.statusText}`);
                alert('Translation request failed.');
                return;
            }

            // parse response and update the thread content
            const data = await response.json();
            const translatedTitle = data[0]?.translations[0]?.text || originalTitle;
            const translatedBody = data[1]?.translations[0]?.text || originalBody;

            threadTitleElement.innerHTML = translatedTitle;
            threadBodyElement.innerHTML = translatedBody;
            translateLinkElement.innerText ='{{__('messages.show_original')}}';
        } catch (error) {
            console.error('Translation error:', error);
            alert('Failed to translate the text.');
        }
    } else {
        threadTitleElement.innerHTML = originalTitle;
        threadBodyElement.innerHTML = originalBody;
        translateLinkElement.innerText ='{{__('messages.translate')}}';
    }
}
</script>


@endsection