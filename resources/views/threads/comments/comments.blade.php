<ul class="list-group bg-light border-0 shadow-sm">
    @foreach ($comments as $comment)

    <li class="list-group-item border-0 bg-light ms-2 ">
        @include('profile.profileBanner', ['object' => $comment])

        <p class="my-3" id="comment-body-{{ $comment->id }}" data-full-content="{{ $comment->body }}">
            {{ $comment->body }}
        </p>
        <a href="javascript:void(0)" id="translate-comment-link-{{ $comment->id }}" onclick="translateComment({{ $comment->id }})" class="text-primary">
            @lang('messages.translate')
        </a>
        @include('threads.vote.vote', ['object' => $comment, 'type' => 'comment'])
        
        @if ($comment->childComments->isNotEmpty())
        <ul class="list-group">
            <div class="border-left">

                @include('threads.comments.comments', ['comments' => $comment->childComments])
            </div>
        </ul>
        @endif

    </li>
    @endforeach
    
</ul>

<script>
async function translateComment(commentId) {
    event.stopPropagation();

    const commentBodyElement = document.getElementById(`comment-body-${commentId}`);
    const translateLinkElement = document.getElementById(`translate-comment-link-${commentId}`);

    if (!translateLinkElement || !commentBodyElement) {
        console.error('Translate link or comment element not found.');
        return;
    }

    const originalBody = commentBodyElement.dataset.fullContent;
    var targetLocale = '{{ app()->getLocale() }}';  // set locale as target lang

    // Handle special case for "jp" -> "ja"
    if(targetLocale == 'jp'){
        targetLocale = 'ja';
    }

    console.log('Original Text:', originalBody); // check the text being sent
    console.log('Target Locale:', targetLocale); // check target lang

    if (translateLinkElement.innerText === '{{ __('messages.translate') }}') {
        try {
            // Set the API url and params
            const endpoint = '{{ config('services.azure_translator.endpoint') }}';
            const location = '{{ config('services.azure_translator.region') }}';
            const path = '/translate';
            const constructedUrl = endpoint + path;

            const params = {
                'api-version': '3.0',
                'to': [targetLocale]
            };

            const headers = {
                'Ocp-Apim-Subscription-Key': '{{ config('services.azure_translator.key') }}',
                'Ocp-Apim-Subscription-Region': location,
                'Content-Type': 'application/json',
                'X-ClientTraceId': String(Math.floor(Math.random() * 1000000))
            };

            const body = [{ 'text': originalBody }];

            // Send POST request to Azure Translator API
            const response = await fetch(constructedUrl + '?' + new URLSearchParams(params), {
                method: 'POST',
                headers: headers,
                body: JSON.stringify(body)
            });

            if (!response.ok) {
                console.error(`Error: ${response.status} - ${response.statusText}`);
                alert('Translation request failed.');
                return;
            }

            // Parse response and update the comment body
            const data = await response.json();
            const translatedBody = data[0]?.translations[0]?.text || originalBody;

            commentBodyElement.innerHTML = translatedBody;
            translateLinkElement.innerText = '{{ __('messages.show_original') }}';
        } catch (error) {
            console.error('Translation error:', error);
            alert('Failed to translate the text.');
        }
    } else {
        // Revert to original comment body
        commentBodyElement.innerHTML = originalBody;
        translateLinkElement.innerText = '{{ __('messages.translate') }}';
    }
}
</script>
