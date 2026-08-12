function initializeExampleGrid() {
    const page = document.querySelector('[data-grid-animate]');
    if (!page || page.dataset.bound === 'true') return;
    page.dataset.bound = 'true';
    const cards = Array.from(page.querySelectorAll('.mosaic-card'));
    const button = document.querySelector('[data-launch-grid]');
    const play = () => {
        cards.forEach((card, index) => {
            card.classList.remove('is-visible');
            window.setTimeout(() => card.classList.add('is-visible'), index * 55);
        });
    };
    button?.addEventListener('click', play);
    play();
}

function initializeExampleDashboard() {
    const page = document.querySelector('[data-dashboard]');
    if (!page || page.dataset.bound === 'true') return;
    page.dataset.bound = 'true';

    const state = {
        current: 'cars',
        data: {
            cars: [
                { name: 'Renault Clio', status: 'En location', value: 'Retour 14:30', note: 'Citadine idéale pour les trajets courts.' },
                { name: 'Peugeot 208', status: 'Révision', value: 'Demain', note: 'Préparer le véhicule avant la remise en service.' },
                { name: 'Tesla Model 3', status: 'Retard client', value: '19:00', note: 'Relance prévue par téléphone.' },
                { name: 'Citroën C3', status: 'Disponible', value: 'Réservoir plein', note: 'Prête pour une location de courte durée.' },
                { name: 'Volkswagen Golf', status: 'Nettoyage', value: 'Après-midi', note: 'Contrôle de propreté avant la remise.' },
                { name: 'Toyota Yaris', status: 'Réservation confirmée', value: 'Vendredi', note: 'Dossier validé par le client.' },
            ],
            renters: [
                { name: 'Société Alpha', status: 'Contrats actifs', value: '12 dossiers', note: 'Suivi régulier du parc automobile.' },
                { name: 'Camille Martin', status: 'Réservation à confirmer', value: '4 contrats', note: 'Client réactif, dossier prioritaire.' },
                { name: 'Agence Beta', status: 'Facturation en cours', value: '8 contrats', note: 'Nécessite un point sur les factures.' },
                { name: 'Groupe Atlas', status: 'Compte premium', value: '16 contrats', note: 'Historique stable et volume élevé.' },
                { name: 'Nora Dubois', status: 'Relance à faire', value: '2 contrats', note: 'Attente de validation du devis.' },
                { name: 'Studio Horizon', status: 'Nouveau client', value: '1 contrat', note: 'Premier dossier en cours de création.' },
            ],
            payments: [
                { name: 'Facture 128', status: 'Payée', value: '580 €', note: 'Paiement validé par carte bancaire.' },
                { name: 'Facture 129', status: 'En attente', value: '320 €', note: 'En attente de virement.' },
                { name: 'Facture 130', status: 'À relancer', value: '1 120 €', note: 'Relance prévue demain.' },
                { name: 'Facture 131', status: 'Partielle', value: '210 €', note: 'Acompte reçu, solde à venir.' },
                { name: 'Facture 132', status: 'Validée', value: '760 €', note: 'Paiement confirmé par la comptabilité.' },
                { name: 'Facture 133', status: 'Litige', value: '940 €', note: 'Vérification en cours avec le client.' },
            ],
            repairs: [
                { name: 'Freinage', status: 'Commande en attente', value: 'Priorité haute', note: 'Pièces à commander rapidement.' },
                { name: 'Vidange', status: 'À planifier', value: 'Semaine prochaine', note: 'À prévoir dans le planning atelier.' },
                { name: 'Carrosserie', status: 'Devis reçu', value: 'En validation', note: 'Devis reçu ce matin.' },
                { name: 'Pneus arrière', status: 'En cours', value: 'Garage Nord', note: 'Montage prévu dans l’après-midi.' },
                { name: 'Climatisation', status: 'À contrôler', value: 'Diagnostic', note: 'Recherche de fuite programmée.' },
                { name: 'Éclairage', status: 'Terminé', value: 'Validé', note: 'Remplacement des ampoules effectué.' },
            ],
        },
    };

    const sections = Array.from(page.querySelectorAll('[data-section]'));
    const navLinks = Array.from(page.querySelectorAll('[data-section-link]'));
    const list = page.querySelector('[data-list="cars"]');

    const renderCars = () => {
        if (!list) return;
        list.innerHTML = state.data.cars.map((item, index) => `
            <div class="col-md-6 col-xl-4 mb-4 dashboard-reveal is-visible" style="transition-delay:${index * 0.05}s">
                <div class="dashboard-card p-3 h-100">
                    <p class="small text-uppercase fw-bold text-muted mb-2">${item.status}</p>
                    <h3 class="h5 fw-bold text-dark">${item.name}</h3>
                    <p class="text-muted mb-2">${item.value}</p>
                    <p class="mb-0 text-secondary">${item.note}</p>
                </div>
            </div>
        `).join('');
    };

    const renderSection = (section) => {
        sections.forEach((item) => item.classList.toggle('is-active', item.dataset.section === section));
        navLinks.forEach((link) => link.classList.toggle('active', link.dataset.sectionLink === section));
        state.current = section;
        if (section === 'cars') {
            renderCars();
        } else {
            const target = page.querySelector(`[data-section="${section}"]`);
            if (target) {
                target.innerHTML = `<div class="dashboard-card p-4"><h2 class="h4 fw-bold mb-3">${section}</h2><p class="mb-0 text-secondary">Contenu factice pour ${section}.</p></div>`;
            }
        }
    };

    navLinks.forEach((link) => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            renderSection(link.dataset.sectionLink);
        });
    });

    page.querySelectorAll('[data-dashboard-reveal]').forEach((node, index) => {
        node.classList.add('dashboard-reveal');
        window.setTimeout(() => node.classList.add('is-visible'), index * 70);
    });

    renderSection('cars');
}

function initializeExampleBubbles() {
    const stage = document.querySelector('[data-bubbles-stage]');
    if (!stage || stage.dataset.bound === 'true') return;
    stage.dataset.bound = 'true';
    const bubbles = Array.from(stage.querySelectorAll('[data-bubble]'));
    const titleOutput = document.querySelector('[data-bubble-output-title]');
    const contentOutput = document.querySelector('[data-bubble-output-content]');
    const pointer = { x: window.innerWidth / 2, y: window.innerHeight / 2 };

    const updateBubbleContent = (bubble) => {
        if (!bubble || !titleOutput || !contentOutput) return;
        titleOutput.textContent = bubble.dataset.bubbleTitle ?? '';
        contentOutput.textContent = bubble.dataset.bubbleContent ?? '';
    };

    const moveBubble = (bubble, targetX, targetY, intensity = 1) => {
        const rect = stage.getBoundingClientRect();
        const bubbleRect = bubble.getBoundingClientRect();
        const centerX = bubbleRect.left + bubbleRect.width / 2;
        const centerY = bubbleRect.top + bubbleRect.height / 2;
        const deltaX = targetX - centerX;
        const deltaY = targetY - centerY;
        const nextX = Math.max(8, Math.min(92, parseFloat(bubble.style.left || bubble.dataset.bubbleX || '50') + ((deltaX / rect.width) * 18 * intensity)));
        const nextY = Math.max(12, Math.min(88, parseFloat(bubble.style.top || bubble.dataset.bubbleY || '50') + ((deltaY / rect.height) * 18 * intensity)));
        bubble.style.left = `${nextX}%`;
        bubble.style.top = `${nextY}%`;
        bubble.dataset.bubbleX = `${nextX}`;
        bubble.dataset.bubbleY = `${nextY}`;
    };

    bubbles.forEach((bubble) => {
        bubble.addEventListener('click', () => {
            bubbles.forEach((item) => item.classList.remove('bubble-active'));
            bubble.classList.add('bubble-active');
            updateBubbleContent(bubble);
        });
    });

    stage.addEventListener('pointermove', (event) => {
        pointer.x = event.clientX;
        pointer.y = event.clientY;
        bubbles.forEach((bubble) => {
            const rect = bubble.getBoundingClientRect();
            const distance = Math.hypot(pointer.x - (rect.left + rect.width / 2), pointer.y - (rect.top + rect.height / 2));
            bubble.classList.toggle('bubble-near', distance < 170);
            if (distance < 170) {
                moveBubble(bubble, pointer.x, pointer.y, 0.28);
            }
        });
    });

    document.addEventListener('keydown', (event) => {
        const bubble = bubbles.find((item) => item.dataset.bubbleNumber === event.key);
        if (!bubble) return;
        moveBubble(bubble, pointer.x, pointer.y, 0.8);
        bubble.focus();
        bubble.click();
    });

    if (bubbles[0]) {
        bubbles[0].classList.add('bubble-active');
        updateBubbleContent(bubbles[0]);
    }
}

document.addEventListener('DOMContentLoaded', initializeExampleGrid);
document.addEventListener('DOMContentLoaded', initializeExampleDashboard);
document.addEventListener('DOMContentLoaded', initializeExampleBubbles);
