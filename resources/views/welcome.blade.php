<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Système de Parrainage Électoral</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-sans bg-gray-50 text-gray-800 antialiased">
    <!-- Navbar -->
    <nav class="bg-white shadow-md fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-blue-600 font-bold text-2xl">Parrainage</a>
                </div>
                <div class="hidden md:flex items-center">
                    <div class="flex space-x-4">
                        <a href="#" class="px-3 py-2 text-gray-700 font-medium hover:text-blue-600 transition duration-150">Accueil</a>
                        <a href="#comment-ca-marche" class="px-3 py-2 text-gray-700 font-medium hover:text-blue-600 transition duration-150">Comment ça marche</a>
                        <a href="#faq" class="px-3 py-2 text-gray-700 font-medium hover:text-blue-600 transition duration-150">FAQ</a>
                        <a href="#contact" class="px-3 py-2 text-gray-700 font-medium hover:text-blue-600 transition duration-150">Contact</a>
                    </div>
                    <div class="ml-6 flex items-center space-x-4">
                        <a href="{{ route('parrain.activation') }}" class="px-4 py-2 border border-blue-600 text-blue-600 rounded-full font-medium hover:bg-blue-50 transition duration-150">Activer mon compte</a>
                        <a href="{{ route('parrainage.verification') }}" class="px-4 py-2 bg-blue-600 text-white rounded-full font-medium hover:bg-blue-700 transition duration-150">Parrainer un candidat</a>
                        <a href="{{ route('candidat.login') }}" class="px-4 py-2 border border-purple-600 text-purple-600 rounded-full font-medium hover:bg-purple-50 transition duration-150">Espace candidat</a>
                    </div>
                </div>
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="#" class="block px-3 py-2 text-gray-700 font-medium hover:bg-gray-50">Accueil</a>
                <a href="#comment-ca-marche" class="block px-3 py-2 text-gray-700 font-medium hover:bg-gray-50">Comment ça marche</a>
                <a href="#faq" class="block px-3 py-2 text-gray-700 font-medium hover:bg-gray-50">FAQ</a>
                <a href="#contact" class="block px-3 py-2 text-gray-700 font-medium hover:bg-gray-50">Contact</a>
                <div class="pt-4 pb-2 border-t border-gray-200">
                    <a href="{{ route('parrain.activation') }}" class="block w-full text-center px-4 py-2 border border-blue-600 text-blue-600 rounded-md font-medium hover:bg-blue-50 mb-2">Activer mon compte</a>
                    <a href="{{ route('parrainage.verification') }}" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-md font-medium hover:bg-blue-700 mb-2">Parrainer un candidat</a>
                    <a href="{{ route('candidat.login') }}" class="block w-full text-center px-4 py-2 border border-purple-600 text-purple-600 rounded-md font-medium hover:bg-purple-50">Espace candidat</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class=" bg-gradient-to-r from-blue-600 to-blue-500 text-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div class="flex flex-col justify-center pt-32 pb-20">
                    <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">Plateforme de Parrainage Électoral</h1>
                    <p class="text-lg mb-8 text-blue-100 max-w-xl">Un système sécurisé, transparent et moderne qui permet aux électeurs de parrainer le candidat de leur choix pour les prochaines élections présidentielles.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('parrainage.verification') }}" class="px-8 py-3 bg-white text-blue-600 rounded-full font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-1 transition duration-300">Parrainer un candidat</a>
                        <a href="{{ route('parrain.activation') }}" class="px-8 py-3 bg-transparent border-2 border-white text-white rounded-full font-semibold hover:bg-white hover:bg-opacity-10 transform hover:-translate-y-1 transition duration-300">Activer mon compte</a>
                        <a href="{{ route('candidat.login') }}" class="px-8 py-3 bg-purple-600 text-white rounded-full font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-1 transition duration-300">Espace candidat</a>
                    </div>
                </div>
                <div class="hidden lg:flex h-full w-auto justify-center items-center bg-red-900">
                    <img  src="https://ichef.bbci.co.uk/news/1024/branded_afrique/96c4/live/82b4e150-62bc-11ee-a8e6-efc60698ab1d.jpg" alt="Illustration" class="max-w-full h-full">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12 relative">
                Notre système de parrainage
                <span class="block w-24 h-1 bg-blue-500 mx-auto mt-3"></span>
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-lg p-8 transform transition duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <div class="text-blue-500 text-4xl mb-4">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Sécurisé et confidentiel</h3>
                    <p class="text-gray-600">Notre système de parrainage assure la confidentialité de vos données et sécurise votre choix grâce à une authentification multi-niveaux.</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-8 transform transition duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <div class="text-blue-500 text-4xl mb-4">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Simple et rapide</h3>
                    <p class="text-gray-600">L'ensemble du processus de parrainage ne prend que quelques minutes et peut être effectué depuis n'importe quel appareil connecté.</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-8 transform transition duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <div class="text-blue-500 text-4xl mb-4">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Fiable et transparent</h3>
                    <p class="text-gray-600">Notre plateforme garantit la traçabilité et l'intégrité du processus de parrainage, avec des confirmations à chaque étape.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="comment-ca-marche" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12 relative">
                Comment ça marche ?
                <span class="block w-24 h-1 bg-blue-500 mx-auto mt-3"></span>
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-16">
                <div class="relative pl-16">
                    <div class="absolute left-0 top-0 flex items-center justify-center w-12 h-12 rounded-full bg-blue-600 text-white text-xl font-bold">1</div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Vérification d'identité</h3>
                        <p class="text-gray-600">Entrez votre numéro d'électeur et votre numéro de CIN pour vous identifier en tant qu'électeur inscrit.</p>
                    </div>
                </div>
                <div class="relative pl-16">
                    <div class="absolute left-0 top-0 flex items-center justify-center w-12 h-12 rounded-full bg-blue-600 text-white text-xl font-bold">2</div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Authentification sécurisée</h3>
                        <p class="text-gray-600">Utilisez le code d'authentification qui vous a été fourni pour sécuriser votre session de parrainage.</p>
                    </div>
                </div>
                <div class="relative pl-16">
                    <div class="absolute left-0 top-0 flex items-center justify-center w-12 h-12 rounded-full bg-blue-600 text-white text-xl font-bold">3</div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Choix du candidat</h3>
                        <p class="text-gray-600">Parcourez la liste des candidats éligibles et sélectionnez celui ou celle que vous souhaitez parrainer.</p>
                    </div>
                </div>
                <div class="relative pl-16">
                    <div class="absolute left-0 top-0 flex items-center justify-center w-12 h-12 rounded-full bg-blue-600 text-white text-xl font-bold">4</div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Confirmation par code unique</h3>
                        <p class="text-gray-600">Recevez un code de confirmation par email et validez votre parrainage pour finaliser le processus.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-16 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12 relative">
                Questions fréquemment posées
                <span class="block w-24 h-1 bg-blue-500 mx-auto mt-3"></span>
            </h2>
            
            <div class="divide-y divide-gray-200">
                <div class="py-6">
                    <details class="group">
                        <summary class="flex justify-between items-center font-medium cursor-pointer">
                            <span class="text-lg">Qui peut parrainer un candidat ?</span>
                            <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <p class="text-gray-600 mt-3 group-open:animate-fadeIn">
                            Tous les électeurs inscrits sur les listes électorales peuvent parrainer un candidat. Il suffit d'avoir son numéro d'électeur, sa CIN et le code d'authentification reçu.
                        </p>
                    </details>
                </div>
                
                <div class="py-6">
                    <details class="group">
                        <summary class="flex justify-between items-center font-medium cursor-pointer">
                            <span class="text-lg">Est-il possible de changer mon choix de parrainage ?</span>
                            <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <p class="text-gray-600 mt-3 group-open:animate-fadeIn">
                            Non, une fois votre parrainage confirmé, il n'est plus possible de le modifier. Chaque électeur ne peut parrainer qu'un seul candidat pour une élection donnée.
                        </p>
                    </details>
                </div>
                
                <div class="py-6">
                    <details class="group">
                        <summary class="flex justify-between items-center font-medium cursor-pointer">
                            <span class="text-lg">Comment obtenir mon code d'authentification ?</span>
                            <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <p class="text-gray-600 mt-3 group-open:animate-fadeIn">
                            Votre code d'authentification est généré lors de l'activation de votre compte de parrain. Si vous n'avez pas encore activé votre compte, vous pouvez le faire en cliquant sur le bouton "Activer mon compte".
                        </p>
                    </details>
                </div>
                
                <div class="py-6">
                    <details class="group">
                        <summary class="flex justify-between items-center font-medium cursor-pointer">
                            <span class="text-lg">Le système est-il sécurisé ?</span>
                            <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <p class="text-gray-600 mt-3 group-open:animate-fadeIn">
                            Oui, notre plateforme utilise une authentification à plusieurs niveaux et des connexions sécurisées pour protéger vos données et l'intégrité du processus de parrainage.
                        </p>
                    </details>
                </div>
                
                <div class="py-6">
                    <details class="group">
                        <summary class="flex justify-between items-center font-medium cursor-pointer">
                            <span class="text-lg">Je suis candidat, comment suivre mes parrainages ?</span>
                            <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <p class="text-gray-600 mt-3 group-open:animate-fadeIn">
                            Les candidats enregistrés peuvent accéder à leur espace personnel en cliquant sur "Espace candidat". Connectez-vous avec votre adresse email et le code d'authentification qui vous a été fourni lors de votre enregistrement pour suivre l'évolution quotidienne de vos parrainages.
                        </p>
                    </details>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-gradient-to-r from-green-600 to-green-500 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Participez au processus démocratique</h2>
            <p class="text-lg mb-8 mx-auto max-w-2xl text-green-100">Votre parrainage compte. Contribuez au processus électoral en parrainant le candidat de votre choix dès maintenant.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('parrainage.verification') }}" class="inline-block px-8 py-3 bg-white text-green-600 rounded-full font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-1 transition duration-300">Parrainer un candidat</a>
                <a href="{{ route('candidat.login') }}" class="inline-block px-8 py-3 bg-purple-600 text-white rounded-full font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-1 transition duration-300">Accéder à mon espace candidat</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-900 text-white pt-16 pb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="col-span-1 lg:col-span-2">
                    <h5 class="text-xl font-semibold mb-4">À propos de la plateforme</h5>
                    <p class="text-gray-300 mb-6">Notre plateforme de parrainage électoral est un système moderne et sécurisé conçu pour faciliter et fiabiliser le processus de parrainage des candidats aux élections présidentielles.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-white hover:bg-blue-600 transition duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-white hover:bg-blue-400 transition duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-white hover:bg-pink-600 transition duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-white hover:bg-blue-700 transition duration-300">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h5 class="text-xl font-semibold mb-4">Liens rapides</h5>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition duration-150">Accueil</a></li>
                        <li><a href="#comment-ca-marche" class="text-gray-300 hover:text-white transition duration-150">Comment ça marche</a></li>
                        <li><a href="#faq" class="text-gray-300 hover:text-white transition duration-150">FAQ</a></li>
                        <li><a href="{{ route('parrain.activation') }}" class="text-gray-300 hover:text-white transition duration-150">Activer mon compte</a></li>
                        <li><a href="{{ route('parrainage.verification') }}" class="text-gray-300 hover:text-white transition duration-150">Parrainer un candidat</a></li>
                        <li><a href="{{ route('candidat.login') }}" class="text-gray-300 hover:text-white transition duration-150">Espace candidat</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-xl font-semibold mb-4">Contactez-nous</h5>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1.5 mr-3 text-gray-400"></i>
                            <span class="text-gray-300">123, Avenue de la République</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-3 text-gray-400"></i>
                            <span class="text-gray-300">+221 77 123 45 67</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-gray-400"></i>
                            <span class="text-gray-300">contact@parrainage.sn</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-6 text-center">
                <p class="text-sm text-gray-400">© 2023 Système de Parrainage Électoral. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking on a link
        const mobileLinks = document.querySelectorAll('#mobile-menu a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('mobile-menu').classList.add('hidden');
            });
        });
    </script>
</body>
</html>
