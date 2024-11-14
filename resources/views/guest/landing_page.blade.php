<style>
	#open_searchbox_btn{
		display: none;
	}
    .nav{
        display: none;
    }
    footer{
        display: none;
    }
</style>

<x-app-layout>
	<x-slot name="title">{{ __('Home') }}</x-slot>
    <style>
        #open_searchbox_btn {
            display: none;
        }

        #search-results {
            display: none;
        }

        #search-results.active {
            display: block;
        }

        .section {
            height: 500vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            overflow: hidden;
        }
        .background-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .content {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out;
            color: #ffffff;
        }

        .content h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .content a h1 {
            font-size: 2rem;
            margin: 1rem;
        }
        .content p {
            font-size: 1.25rem;
            max-width: 600px;
        }
        .fade-out {
            opacity: 0;
            transform: translate(-50%, -60%);
        }

        .fade-in {
            opacity: 1;
            transform: translate(-50%, -50%);
        }
    </style>
        <!-- Landing Page Sections -->
        <div class="section">
            <video class="background-video" autoplay muted loop>
                <source src="{{ asset('storage/landing_bg.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="content fade-in">
                <h1 class="text-red-500 font-bold bg-white">Welcome to Our Bookstore</h1>
                <p class="">Discover a world of books at your fingertips. From bestsellers to hidden gems, we have it all.</p>
                <a href="{{ route('home') }}"><p class="rounded py-2 mt-4 text-white bg-red-500 hover:bg-white hover:text-red-500 transition duration-300 ease-in-out transform hover:scale-105">Explore now</p></a>
            </div>
        </div>

    <script>
        const sections = [
            {
                title: "Welcome to Our Bookstore",
                content: "Discover a world of books at your fingertips. From bestsellers to hidden gems, we have it all.",
                link: "{{route('home')}}",
                linkText: "Explore now"
            },
            {
                title: "Wide Range of Genres",
                content: "Explore our extensive collection of genres to find the perfect book for you.",
                link: "#",
                linkText: "Browse genres"
            },
            {
                title: "Exclusive Discounts",
                content: "Enjoy exclusive discounts and offers on your favorite books. Don't miss out!",
                link: "#",
                linkText: "See discounts"
            },
            {
                title: "Join Our Community",
                content: "Become a part of our vibrant community of book lovers. Share your reviews and recommendations.",
                link: "#",
                linkText: "Join now"
            }
        ];

        let currentSection = 0;

        window.addEventListener('scroll', () => {
            const scrollPosition = window.scrollY;
            const totalHeight = document.body.scrollHeight - window.innerHeight;
            const scrollFraction = scrollPosition / totalHeight;
            const sectionIndex = Math.floor(scrollFraction * sections.length);

            const content = document.querySelector('.content');
            if (sectionIndex !== currentSection) {
                content.classList.remove('fade-in');
                content.classList.add('fade-out');

                setTimeout(() => {
                    content.querySelector('h1').textContent = sections[sectionIndex].title;
                    content.querySelector('p').textContent = sections[sectionIndex].content;
                    const link = content.querySelector('a');
                    link.href = sections[sectionIndex].link;
                    link.querySelector('p').textContent = sections[sectionIndex].linkText;
                    content.classList.remove('fade-out');
                    content.classList.add('fade-in');
                    currentSection = sectionIndex;
                }, 200);
            }
        });
    </script>
</x-app-layout>
