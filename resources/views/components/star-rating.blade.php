<div class="flex justify-between items-center space-x-1 relative z-20">
    <p>¿Qué te pareció?</p>
    <form id="ratingForm" method="POST" action="{{ route('rating.setRating', ['mediaId' => $mediaId->id, 'mediaType' => $mediaType]) }}">
        @csrf
        <input type="hidden" name="rating" id="ratingInput">

        @for ($i = 1; $i <= 5; $i++)
            <i class="fas fa-star cursor-pointer 
                @if($i <= $rating) text-yellow-500 @else text-gray-300 @endif"
                data-index="{{ $i }}"
                data-rating="{{ $i }}"
                onclick="setRating({{ $i }})"
                onmouseover="highlightStars({{ $i }})" 
                onmouseout="resetStars()"
                data-initial-rating="{{ $rating }}"></i>
        @endfor
    </form>
</div>
<p class="text-neutral-400">
    Opinión del público: 
    @if ($avgRating)
        {{ number_format($avgRating, 1) }} / 5
    @else
        N/A
    @endif
</p>

<script>
    function setRating(rating) {
        document.getElementById('ratingInput').value = rating;
        document.getElementById('ratingForm').submit();
    }

    function highlightStars(index) {
        const stars = document.querySelectorAll('.fa-star');
        stars.forEach((star, i) => {
            if (i < index) {
                star.classList.add('text-yellow-500');
            } else {
                star.classList.remove('text-yellow-500');
            }
        });
    }

    function resetStars() {
        const stars = document.querySelectorAll('.fa-star');
        stars.forEach(star => {
            const initialRating = parseInt(star.getAttribute('data-initial-rating'));
            const starIndex = parseInt(star.getAttribute('data-index'));

            if (starIndex <= initialRating) {
                star.classList.add('text-yellow-500');
                star.classList.remove('text-gray-300');
            } else {
                star.classList.add('text-gray-300');
                star.classList.remove('text-yellow-500');
            }
        });
    }
</script>
