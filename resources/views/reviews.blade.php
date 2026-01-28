@php
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
if(Review::where('email', Auth::user()->email)->count() > 0)
{
$review = Review::where('email', Auth::user()->email)->first();
}
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reviews
        </h2>
    </x-slot>
    <div class="lg:py-9 py-[1rem]"></div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden sm:rounded-lg mx-[1rem] mb-[1rem]">
            <div class="p-6 bg-white border-b border-gray-200 space-y-6">
                @if(session('success'))
                    <div class="p-4 mb-6 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
                @elseif (session('error'))
                    <div class="p-4 mb-6 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
                @endif
                @if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                <h3 class="text-[22px] font-medium text-gray-900">Klant reviews.</h3>
                    <ul class="space-y-4">
                        @foreach($reviews as $review)
                        <li class="p-[2rem] rounded-[10px] border-[1px] border-[#d1d1d1] flex flex-col">
                            <div class="text-black opacity-50 text-[18px] mb-[0.5rem]">Review van {{ $review->name }}:</div>
                            <p class="text-black mt-[0.5rem] font-medium">Aantal gegeven sterren:</p>
                            <div class="flex items-center gap-[0.5rem]">
                                @for($i = 0; $i < $review->rating; $i++)
                                    <i class="bi bi-star-fill text-yellow-400"></i>
                                @endfor
                            </div>
                            <p class="text-black mt-[1rem] font-medium">Bericht:</p>
                            <div class="text-base text-gray-800 italic" id="review-details">"{{ $review->review_details }}"</div>
                            <button id="generate-text" class="text-white font-bold bg-[#FEA116] px-4 py-[0.75rem] mt-4 rounded-[5px] hover:bg-[#E68F0C] transition">
                                Verbetervoorstel bekijken
                            </button>
                            <span id="generated-text" class="block mt-2"></span>
                            <div class="mt-3 text-sm text-gray-500">{{ $review->created_at->locale('nl')->diffForHumans() }}</div>
                        </li>
                        @endforeach
                    </ul>
                @elseif(Review::where('email', Auth::user()->email)->count() == 0)
                    <h3 class="text-[22px] font-medium text-gray-900">Laat een beoordeling achter.</h3>
                    <form action="{{ route('reviews.store') }}" method="POST" class="flex flex-col gap-[1rem]">
                        @csrf
                        <div>
                            <label for="rating" class="block text-gray-700 mb-[0.10rem]">Hoeveel sterren geeft u ons?</label>
                            <div class="flex gap-[0.5rem]">
                                @for ($i = 1; $i <= 5; $i++)
                                    <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" class="hidden">
                                    <label for="star{{ $i }}" class="bi bi-star-fill text-[#cecece] cursor-pointer" data-value="{{ $i }}"></label>
                                @endfor
                            </div>
                        </div>
                        <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                        <div>
                            <label for="review_details" class="block text-gray-700 mb-[0.40rem]">Beschrijf uw ervaring met ChezLeo</label>
                            <input type="text" name="review_details" class="rounded-[5px] block w-full p-2 border border-gray-300">
                        </div>
                        <input type="submit" name="submit" value="Review versturen" class="bg-[#FEA116] text-white px-4 py-[0.75rem] mt-[1.5rem] transition font-bold rounded-[5px] hover:bg-[#E68F0C]">
                    </form>
                @else
                    <h3 class="text-[22px] font-medium text-gray-900">Pas uw beoordeling aan</h3>
                    <form action="{{ route('reviews.update', $review->id) }}" method="POST" class="flex flex-col gap-[1rem]">
                        @csrf
                        @method('PUT')
                        <div>
                        <label for="rating" class="block text-gray-700 mb-[0.10rem]">Hoeveel sterren geeft u ons?</label>
                            <div class="flex gap-[0.5rem]">
                                @for ($i = 1; $i <= 5; $i++)
                                    <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" class="hidden">
                                    <label for="star{{ $i }}" class="bi bi-star-fill cursor-pointer {{ Review::where('email', Auth::user()->email)->first()->rating >= $i ? 'text-yellow-400' : 'text-gray-400' }}" data-value="{{ $i }}"></label>
                                    @endfor
                            </div>
                        </div>
                        <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                        <div>
                            <label for="review_details" class="block text-gray-700 mb-[0.40rem]">Beschrijf uw beoordeling</label>
                            <input type="text" name="review_details" value="{{ $review->review_details }}" class="rounded-[5px] block w-full p-2 border border-gray-300">
                        </div>
                        <input type="submit" name="submit" value="Aanpassing versturen" class="bg-[#FEA116] text-white px-4 py-[0.75rem] mt-[1.5rem] transition font-bold rounded-[5px] hover:bg-[#E68F0C]">
                    </form>
                    <form action="{{ route('reviews.delete', $review->id) }}" method="POST" onclick="alert()" class="flex items-center justify-center">
                        @csrf
                        @method('DELETE')
                        <input type="submit" name="submit" value="Verwijderen" class="w-fit -mt-[1rem] text-red-500 py-[0.75rem] transition font-bold rounded-[5px]">
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>


<script>
    document.querySelectorAll('#generate-text').forEach(button => {
        button.addEventListener('click', function() {
            const review = button.parentElement.querySelector("#review-details").innerHTML;
            fetch('/reviews/analyze', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        review: review
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    button.parentElement.querySelector("#generated-text").innerHTML = data.data;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });

    function alert() {
        if (!confirm('Weet u zeker dat u deze review wilt verwijderen?')) {
            event.preventDefault();
        }
    }

    // Highlight stars on click
    document.querySelectorAll('.bi-star-fill').forEach(star => {
        star.addEventListener('click', function() {
            const rating = star.getAttribute('data-value');
            document.querySelectorAll('.bi-star-fill').forEach(s => s.classList.remove('text-yellow-400'));
            document.querySelectorAll('.bi-star-fill').forEach(s => s.classList.add('text-gray-400'));
            for (let i = 1; i <= rating; i++) {
                document.querySelector(`.bi-star-fill[data-value="${i}"]`).classList.add('text-yellow-400');
            }
        });
    });
</script>