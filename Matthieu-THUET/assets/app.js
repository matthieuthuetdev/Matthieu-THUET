import './stimulus_bootstrap.js';
import './styles/app.css';

function getHomeNavHeight() {
    const nav = document.querySelector('.home-nav');

    return nav ? nav.offsetHeight : 0;
}

function scrollToElement(selector, behavior = 'auto') {
    if (!selector || !selector.startsWith('#')) {
        return;
    }

    const target = document.querySelector(selector);

    if (!target) {
        return;
    }

    window.requestAnimationFrame(() => {
        const navHeight = getHomeNavHeight();
        const targetTop =
            window.scrollY +
            target.getBoundingClientRect().top -
            navHeight;

        window.scrollTo({
            top: Math.max(0, targetTop),
            behavior,
        });
    });
}

function restorePagePosition() {
    const homePage = document.querySelector('.home-page');

    if (homePage?.dataset.scrollContact === 'true') {
        scrollToElement('#bloc-contact');
        return;
    }

    const { hash } = window.location;

    if (!hash || !hash.startsWith('#')) {
        return;
    }

    scrollToElement(hash);
}

function initializeHomePageInteractions() {
    const navLinks = Array.from(
        document.querySelectorAll('[data-home-nav-link]')
    );

    const navMenu = document.querySelector('#homeNavMenu');
    const nav = document.querySelector('.home-nav');
    const menuLinks = navMenu
        ? Array.from(
              navMenu.querySelectorAll(
                  '[data-home-nav-link]'
              )
          )
        : [];

    if (!navLinks.length) {
        return;
    }

    const sections = navLinks
        .map((link) => {
            const selector = link.getAttribute('href');

            if (!selector || !selector.startsWith('#')) {
                return null;
            }

            const section = document.querySelector(selector);

            if (!section) {
                return null;
            }

            const visibleLink =
                menuLinks.find(
                    (menuLink) =>
                        menuLink.getAttribute('href') ===
                        selector
                ) ?? link;

            return {
                link: visibleLink,
                section
            };
        })
        .filter(Boolean);

    const setActiveLink = (activeLink) => {
        navLinks.forEach((link) => {
            const isActive = link === activeLink;

            link.classList.toggle('is-active', isActive);

            if (isActive) {
                link.setAttribute('aria-current', 'page');
            } else {
                link.removeAttribute('aria-current');
            }
        });
    };

    const updateActiveSection = () => {
        if (!sections.length) {
            return;
        }

        const screenCenter = window.innerHeight / 2;

        let activeSection = sections[0];
        let closestDistance = Infinity;

        sections.forEach((item) => {
            const rect = item.section.getBoundingClientRect();
            const sectionCenter =
                rect.top + rect.height / 2;
            const distance = Math.abs(
                sectionCenter - screenCenter
            );

            if (distance < closestDistance) {
                closestDistance = distance;
                activeSection = item;
            }
        });

        setActiveLink(activeSection.link);
    };

    navLinks.forEach((link) => {
        if (link.dataset.homeNavBound === 'true') {
            return;
        }

        link.dataset.homeNavBound = 'true';

        link.addEventListener('click', (event) => {
            const targetId = link.getAttribute('href');

            if (!targetId || !targetId.startsWith('#')) {
                return;
            }

            const target = document.querySelector(targetId);

            if (!target || !nav) {
                return;
            }

            event.preventDefault();

            setActiveLink(link);

            const navHeight = nav.offsetHeight;

            const targetTop =
                window.scrollY +
                target.getBoundingClientRect().top -
                navHeight;

            window.scrollTo({
                top: targetTop,
                behavior: 'smooth'
            });

            if (
                navMenu &&
                navMenu.classList.contains('show') &&
                window.jQuery
            ) {
                window.jQuery(navMenu).collapse('hide');
            }
        });
    });

    let ticking = false;

    const handleScroll = () => {
        if (ticking) {
            return;
        }

        ticking = true;

        window.requestAnimationFrame(() => {
            updateActiveSection();
            ticking = false;
        });
    };

    window.addEventListener('scroll', handleScroll, {
        passive: true
    });

    window.addEventListener('resize', updateActiveSection);

    updateActiveSection();

    const toggleButtons = Array.from(
        document.querySelectorAll('[data-home-toggle]')
    );

    toggleButtons.forEach((button) => {
        if (button.dataset.homeToggleBound === 'true') {
            return;
        }

        button.dataset.homeToggleBound = 'true';

        button.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();

            const panelName = button.dataset.homeToggle;

            const panel = document.querySelector(
                `[data-home-panel="${panelName}"]`
            );

            if (!panel) {
                return;
            }

            const isOpen = !panel.hidden;

            button.setAttribute(
                'aria-expanded',
                isOpen ? 'false' : 'true'
            );

            if (isOpen) {
                panel.style.maxHeight = `${panel.scrollHeight}px`;

                panel.classList.remove(
                    'home-expandable-panel-open'
                );

                window.requestAnimationFrame(() => {
                    panel.style.maxHeight = '0px';
                });

                window.setTimeout(() => {
                    panel.hidden = true;
                    panel.style.maxHeight = '';
                }, 500);

                return;
            }

            panel.hidden = false;
            panel.style.maxHeight = '0px';

            window.requestAnimationFrame(() => {
                panel.style.maxHeight = `${panel.scrollHeight}px`;

                panel.classList.add(
                    'home-expandable-panel-open'
                );
            });

            window.setTimeout(() => {
                panel.style.maxHeight = 'none';
            }, 500);
        });
    });
}
function initializeExampleGrid() {
    const page = document.querySelector(
        '[data-example-grid-page]'
    );

    if (
        !page ||
        page.dataset.exampleGridBound === 'true'
    ) {
        return;
    }

    page.dataset.exampleGridBound = 'true';

    const cards = Array.from(
        page.querySelectorAll('[data-example-card]')
    );

    cards.forEach((card, index) => {
        window.setTimeout(() => {
            card.classList.add('is-visible');
        }, index * 55);
    });
}

function initializeExampleDashboard() {
    const page = document.querySelector(
        '[data-example-dashboard]'
    );

    if (
        !page ||
        page.dataset.exampleDashboardBound === 'true'
    ) {
        return;
    }

    page.dataset.exampleDashboardBound = 'true';

    const storageKey =
        'example-dashboard-state';

    const navButtons = Array.from(
        page.querySelectorAll(
            '[data-dashboard-target]'
        )
    );

    const sections = Array.from(
        page.querySelectorAll(
            '[data-dashboard-section]'
        )
    );

    const sectionTitle = page.querySelector(
        '[data-dashboard-section-title]'
    );

    const drawer = page.querySelector(
        '[data-dashboard-drawer]'
    );

    const drawerCloseButtons = Array.from(
        page.querySelectorAll(
            '[data-dashboard-drawer-close]'
        )
    );

    const drawerTitle = page.querySelector(
        '[data-dashboard-drawer-title]'
    );

    const drawerHeading = page.querySelector(
        '[data-dashboard-drawer-heading]'
    );

    const drawerSections = Array.from(
        page.querySelectorAll(
            '[data-dashboard-drawer-section]'
        )
    );

    const accountForm = page.querySelector(
        '[data-dashboard-form="account"]'
    );

    const settingsForm = page.querySelector(
        '[data-dashboard-form="settings"]'
    );

    const popup = page.querySelector(
        '[data-dashboard-popup]'
    );

    const popupTitle = page.querySelector(
        '[data-dashboard-popup-title]'
    );

    const popupMessage = page.querySelector(
        '[data-dashboard-popup-message]'
    );

    const popupClose = page.querySelector(
        '[data-dashboard-popup-close]'
    );

    const defaultState = {
        activeSection: 'cars',

        account: {
            name: 'Alicia Morel',
            company: 'Nord Mobility',
            phone: '06 12 34 56 78',
            email: 'alicia.morel@example.com',
        },

        settings: {
            theme: 'standard',
            density: 'comfortable',
            animation: 'smooth',
        },
    };

    const dashboardData = {
        cars: {
            title: 'Gestion des voitures',
            sectionLabel: 'Gestion des voitures',
            actionLabel: 'Ajouter une voiture',

            stats: [
                {
                    label: 'Flotte',
                    value: '48',
                    note: 'Véhicules disponibles',
                },
                {
                    label: 'Réparations',
                    value: '7',
                    note: 'Dossiers à suivre',
                },
                {
                    label: 'Paiements',
                    value: '3',
                    note: 'Relances aujourd’hui',
                },
                {
                    label: 'Loueurs',
                    value: '19',
                    note: 'Clients actifs',
                },
            ],

            cards: [
                {
                    label: 'En location',
                    title: 'Renault Clio',
                    subtitle: 'Retour 14:30',
                    text: 'Citadine idéale pour les trajets courts.',
                },
                {
                    label: 'Révision',
                    title: 'Peugeot 208',
                    subtitle: 'Demain',
                    text: 'Préparer le véhicule avant la remise en service.',
                },
                {
                    label: 'Retard client',
                    title: 'Tesla Model 3',
                    subtitle: '19:00',
                    text: 'Relance prévue par téléphone.',
                },
                {
                    label: 'Disponible',
                    title: 'Citroën C3',
                    subtitle: 'Réservoir plein',
                    text: 'Prête pour une location de courte durée.',
                },
                {
                    label: 'Nettoyage',
                    title: 'Volkswagen Golf',
                    subtitle: 'Après-midi',
                    text: 'Contrôle de propreté avant la remise.',
                },
                {
                    label: 'Réservation confirmée',
                    title: 'Toyota Yaris',
                    subtitle: 'Vendredi',
                    text: 'Dossier validé par le client.',
                },
            ],

            asideTitle: 'Actions rapides',

            asideItems: [
                'Préparer l’état des lieux du véhicule le plus demandé.',
                'Confirmer les deux réservations premium de l’après-midi.',
                'Vérifier les documents du nouveau loueur professionnel.',
                'Envoyer la facture du dossier Martin.',
            ],
        },

        renters: {
            title: 'Gestion des loueurs',
            sectionLabel: 'Gestion des loueurs',
            actionLabel: 'Ajouter un loueur',

            stats: [
                {
                    label: 'Loueurs',
                    value: '18',
                    note: 'Clients professionnels',
                },
                {
                    label: 'Nouveaux',
                    value: '4',
                    note: 'Contrats signés cette semaine',
                },
                {
                    label: 'Caution',
                    value: '12',
                    note: 'Dossiers à vérifier',
                },
                {
                    label: 'Renouvellement',
                    value: '5',
                    note: 'Comptes à relancer',
                },
            ],

            cards: [
                {
                    label: 'Actif',
                    title: 'Claire Martin',
                    subtitle: 'Atelier Nord',
                    text: 'Dernier véhicule loué : Peugeot 208.',
                },
                {
                    label: 'Actif',
                    title: 'Julien Morel',
                    subtitle: 'Studio Delta',
                    text: 'Dernier véhicule loué : Renault Clio.',
                },
                {
                    label: 'En attente',
                    title: 'Sophie Bernard',
                    subtitle: 'Maison Rivage',
                    text: 'Dernier véhicule loué : Tesla Model 3.',
                },
                {
                    label: 'Relance',
                    title: 'Karim Diallo',
                    subtitle: 'Delta Transport',
                    text: 'Dernier véhicule loué : Berlingo.',
                },
                {
                    label: 'Nouveau',
                    title: 'Nadia Petit',
                    subtitle: 'Agence Ouest',
                    text: 'Compte créé il y a deux jours.',
                },
                {
                    label: 'Vérification',
                    title: 'Lucas Renard',
                    subtitle: 'Freelance Pro',
                    text: 'Pièce d’identité à contrôler.',
                },
            ],

            asideTitle: 'Documents à suivre',

            asideItems: [
                'Contrat signé à numériser pour le dossier Bernard.',
                'Permis de conduire à revérifier pour trois loueurs.',
                'Attestation d’assurance à renouveler cette semaine.',
                'Pièce d’identité à demander pour un nouveau compte.',
            ],
        },

        payments: {
            title: 'Gestion des paiements',
            sectionLabel: 'Gestion des paiements',
            actionLabel: 'Ajouter un paiement',

            stats: [
                {
                    label: 'Encaissements',
                    value: '12',
                    note: 'Validés aujourd’hui',
                },
                {
                    label: 'À relancer',
                    value: '3',
                    note: 'Factures en attente',
                },
                {
                    label: 'Moyenne',
                    value: '84€',
                    note: 'Montant par transaction',
                },
                {
                    label: 'Solde',
                    value: 'OK',
                    note: 'Situation à jour',
                },
            ],

            cards: [
                {
                    label: 'Payé',
                    title: 'FAC-2048',
                    subtitle: 'Atelier Nord',
                    text: '148 € - location standard réglée.',
                },
                {
                    label: 'À relancer',
                    title: 'FAC-2049',
                    subtitle: 'Studio Delta',
                    text: '76 € - rappel envoyé cet après-midi.',
                },
                {
                    label: 'En attente',
                    title: 'FAC-2050',
                    subtitle: 'Maison Rivage',
                    text: '214 € - validation bancaire en cours.',
                },
                {
                    label: 'Payé',
                    title: 'FAC-2051',
                    subtitle: 'Delta Transport',
                    text: '98 € - reçu envoyé automatiquement.',
                },
                {
                    label: 'Acompte',
                    title: 'FAC-2052',
                    subtitle: 'Nord Mobility',
                    text: '120 € - acompte partiel enregistré.',
                },
                {
                    label: 'Contrôle',
                    title: 'FAC-2053',
                    subtitle: 'Atelier Sud',
                    text: '55 € - pièce manquante à vérifier.',
                },
            ],

            asideTitle: 'Rappels de caisse',

            asideItems: [
                'Envoyer le reçu du dossier FAC-2049.',
                'Vérifier la caution du contrat premium.',
                'Mettre à jour le total encaissé du jour.',
                'Préparer les écritures du prochain point comptable.',
            ],
        },

        repairs: {
            title: 'Gestion des réparations',
            sectionLabel: 'Gestion des réparations',
            actionLabel: 'Ajouter une réparation',

            stats: [
                {
                    label: 'Ateliers',
                    value: '4',
                    note: 'Partenaires actifs',
                },
                {
                    label: 'En cours',
                    value: '6',
                    note: 'Réparations ouvertes',
                },
                {
                    label: 'Prêts',
                    value: '2',
                    note: 'Véhicules à récupérer',
                },
                {
                    label: 'Planifier',
                    value: '5',
                    note: 'Contrôles à venir',
                },
            ],

            cards: [
                {
                    label: 'En cours',
                    title: 'Peugeot 208',
                    subtitle: 'Garage Sud',
                    text: 'Estimation 320 € - carrosserie.',
                },
                {
                    label: 'Prêt demain',
                    title: 'Citroën Berlingo',
                    subtitle: 'Nord Réparations',
                    text: 'Estimation 180 € - freinage.',
                },
                {
                    label: 'Devis reçu',
                    title: 'Renault Clio',
                    subtitle: 'City Garage',
                    text: 'Estimation 540 € - contrôle moteur.',
                },
                {
                    label: 'Diagnostic',
                    title: 'Tesla Model 3',
                    subtitle: 'Electro Service',
                    text: 'Estimation 210 € - électronique.',
                },
                {
                    label: 'Prévu',
                    title: 'Dacia Sandero',
                    subtitle: 'Garage Express',
                    text: 'Révision simple programmée.',
                },
                {
                    label: 'Suivi',
                    title: 'Toyota Yaris',
                    subtitle: 'Atelier Horizon',
                    text: 'Petite intervention à confirmer.',
                },
            ],

            asideTitle: 'Planification atelier',

            asideItems: [
                'Récupérer le dossier peinture de la Clio.',
                'Valider le devis mécanique du Berlingo.',
                'Relancer l’atelier pour la Tesla Model 3.',
                'Préparer le prochain contrôle du parc utilitaire.',
            ],
        },
    };

    const readState = () => {
        try {
            const raw =
                window.localStorage.getItem(storageKey);

            if (!raw) {
                return JSON.parse(
                    JSON.stringify(defaultState)
                );
            }

            const parsed = JSON.parse(raw);

            return {
                activeSection:
                    parsed.activeSection ??
                    defaultState.activeSection,

                account: {
                    ...defaultState.account,
                    ...(parsed.account ?? {}),
                },

                settings: {
                    ...defaultState.settings,
                    ...(parsed.settings ?? {}),
                },
            };
        } catch {
            return JSON.parse(
                JSON.stringify(defaultState)
            );
        }
    };

    const saveState = () => {
        window.localStorage.setItem(
            storageKey,
            JSON.stringify(state)
        );
    };

    let state = readState();

    const hideDrawer = () => {
        if (!drawer) {
            return;
        }

        drawer.classList.remove('is-open');

        window.setTimeout(() => {
            drawer.hidden = true;
        }, 220);
    };

    const showPopup = (title, message) => {
        if (
            !popup ||
            !popupTitle ||
            !popupMessage
        ) {
            return;
        }

        popupTitle.textContent = title;
        popupMessage.textContent = message;

        popup.hidden = false;

        window.requestAnimationFrame(() => {
            popup.classList.add('is-visible');
        });
    };

    const hidePopup = () => {
        if (!popup) {
            return;
        }

        popup.classList.remove('is-visible');

        window.setTimeout(() => {
            popup.hidden = true;
        }, 220);
    };

    const applyPreferences = () => {
        page.classList.toggle(
            'example-dashboard-page--contrast',
            state.settings.theme === 'contrast'
        );

        page.classList.toggle(
            'example-dashboard-page--soft',
            state.settings.theme === 'soft'
        );

        page.classList.toggle(
            'example-dashboard-page--compact',
            state.settings.density === 'compact'
        );

        page.classList.toggle(
            'example-dashboard-page--reduced',
            state.settings.animation === 'reduced'
        );

        if (accountForm) {
            accountForm.querySelector(
                '[name="name"]'
            ).value = state.account.name;

            accountForm.querySelector(
                '[name="company"]'
            ).value = state.account.company;

            accountForm.querySelector(
                '[name="phone"]'
            ).value = state.account.phone;

            accountForm.querySelector(
                '[name="email"]'
            ).value = state.account.email;
        }

        if (settingsForm) {
            settingsForm.querySelector(
                '[name="theme"]'
            ).value = state.settings.theme;

            settingsForm.querySelector(
                '[name="density"]'
            ).value = state.settings.density;

            settingsForm.querySelector(
                '[name="animation"]'
            ).value = state.settings.animation;
        }
    };

    const revealSectionItems = (section) => {
        const items = Array.from(
            section.querySelectorAll(
                '[data-dashboard-animate]'
            )
        );

        items.forEach((item) => {
            item.classList.add('dashboard-reveal');
            item.classList.remove('is-visible');
        });

        items.forEach((item, index) => {
            window.setTimeout(() => {
                item.classList.add('is-visible');
            }, index * 70);
        });
    };

    const renderSection = (name) => {
        const data =
            dashboardData[name] ??
            dashboardData.cars;

        const section =
            sections.find(
                (item) =>
                    item.dataset.dashboardSection === name
            ) ?? sections[0];

        if (!section) {
            return;
        }

        if (sectionTitle) {
            sectionTitle.textContent = data.title;
        }

        section.innerHTML = `
            <div class="row mb-4">
                ${data.stats
                    .map(
                        (stat) => `
                            <div
                                class="col-md-6 col-xl-3 mb-3"
                                data-dashboard-animate
                            >
                                <article class="example-dashboard-metric">
                                    <p class="small text-uppercase font-weight-bold text-muted mb-1">
                                        ${stat.label}
                                    </p>
                                    <p class="display-4 font-weight-bold mb-1">
                                        ${stat.value}
                                    </p>
                                    <p class="mb-0 text-muted">
                                        ${stat.note}
                                    </p>
                                </article>
                            </div>
                        `
                    )
                    .join('')}
            </div>

            <div class="row">
                <div
                    class="col-xl-8 mb-4"
                    data-dashboard-animate
                >
                    <article class="example-dashboard-card h-100">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                            <div>
                                <p class="text-uppercase small font-weight-bold text-muted mb-2">
                                    ${data.sectionLabel}
                                </p>
                                <h3 class="h4 font-weight-bold mb-0">
                                    ${data.title}
                                </h3>
                            </div>

                            <button
                                class="btn btn-dark mt-3 mt-md-0"
                                type="button"
                                data-dashboard-action="add-${name}"
                            >
                                ${data.actionLabel}
                            </button>
                        </div>

                        <div class="row">
                            ${data.cards
                                .map(
                                    (card, index) => `
                                        <div
                                            class="col-md-6 mb-4"
                                            data-dashboard-animate
                                        >
                                            <article class="example-dashboard-item">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <p class="text-uppercase small font-weight-bold text-muted mb-0">
                                                        ${card.label}
                                                    </p>
                                                    <span class="badge badge-dark">
                                                        #${index + 1}
                                                    </span>
                                                </div>

                                                <h4 class="h5 font-weight-bold mb-2">
                                                    ${card.title}
                                                </h4>

                                                <p class="mb-2 text-muted">
                                                    ${card.subtitle}
                                                </p>

                                                <p class="mb-4">
                                                    ${card.text}
                                                </p>

                                                <div class="d-flex flex-wrap gap-2">
                                                    <button
                                                        class="btn btn-outline-dark btn-sm"
                                                        type="button"
                                                        data-dashboard-action="view"
                                                    >
                                                        Voir
                                                    </button>

                                                    <button
                                                        class="btn btn-outline-dark btn-sm"
                                                        type="button"
                                                        data-dashboard-action="edit"
                                                    >
                                                        Modifier
                                                    </button>

                                                    <button
                                                        class="btn btn-outline-danger btn-sm"
                                                        type="button"
                                                        data-dashboard-action="delete"
                                                    >
                                                        Supprimer
                                                    </button>
                                                </div>
                                            </article>
                                        </div>
                                    `
                                )
                                .join('')}
                        </div>
                    </article>
                </div>

                <div
                    class="col-xl-4 mb-4"
                    data-dashboard-animate
                >
                    <article class="example-dashboard-card h-100">
                        <h3 class="h4 font-weight-bold mb-4">
                            ${data.asideTitle}
                        </h3>

                        <ul class="list-unstyled mb-0 example-dashboard-list">
                            ${data.asideItems
                                .map(
                                    (item) =>
                                        `<li>${item}</li>`
                                )
                                .join('')}
                        </ul>
                    </article>
                </div>
            </div>
        `;

        revealSectionItems(section);
    };

    const activateSection = (name) => {
        const targetButton =
            navButtons.find(
                (button) =>
                    button.dataset.dashboardTarget === name
            ) ?? navButtons[0];

        const targetSection =
            sections.find(
                (section) =>
                    section.dataset.dashboardSection === name
            ) ?? sections[0];

        navButtons.forEach((button) => {
            button.classList.toggle(
                'active',
                button === targetButton
            );
        });

        sections.forEach((section) => {
            section.classList.toggle(
                'is-active',
                section === targetSection
            );
        });

        state.activeSection =
            targetSection?.dataset.dashboardSection ??
            defaultState.activeSection;

        saveState();

        renderSection(state.activeSection);
    };

    const setDrawerSection = (name) => {
        drawerSections.forEach((section) => {
            section.classList.toggle(
                'd-none',
                section.dataset.dashboardDrawerSection !== name
            );
        });

        if (drawerTitle && drawerHeading) {
            if (name === 'settings') {
                drawerTitle.textContent = 'Paramètres';
                drawerHeading.textContent =
                    'Préférences d’affichage';
            } else {
                drawerTitle.textContent = 'Mon compte';
                drawerHeading.textContent =
                    'Informations de profil';
            }
        }
    };

    const openDrawer = (name) => {
        if (!drawer) {
            return;
        }

        setDrawerSection(name);

        drawer.hidden = false;

        window.requestAnimationFrame(() => {
            drawer.classList.add('is-open');
        });
    };

    navButtons.forEach((button) => {
        button.addEventListener('click', () => {
            activateSection(
                button.dataset.dashboardTarget ??
                    defaultState.activeSection
            );
        });
    });

    page.addEventListener('click', (event) => {
        const button = event.target.closest(
            '[data-dashboard-action]'
        );

        if (!button || !page.contains(button)) {
            return;
        }

        const action =
            button.dataset.dashboardAction;

        if (action === 'account') {
            openDrawer('account');
            return;
        }

        if (action === 'settings') {
            openDrawer('settings');
            return;
        }

        if (action === 'logout') {
            showPopup(
                'Déconnexion',
                'La déconnexion a été simulée avec succès.'
            );
            return;
        }

        if (
            action === 'view' ||
            action === 'edit' ||
            action === 'delete'
        ) {
            showPopup(
                'Action simulée',
                'Cette action est bien prise en compte dans la démo.'
            );
            return;
        }

        if (action?.startsWith('add-')) {
            showPopup(
                'Ajout simulé',
                'Le nouvel élément a été ajouté dans la démonstration.'
            );
        }
    });

    drawerCloseButtons.forEach((button) => {
        button.addEventListener(
            'click',
            hideDrawer
        );
    });

    drawer?.addEventListener('click', (event) => {
        if (event.target === drawer) {
            hideDrawer();
        }
    });

    popupClose?.addEventListener(
        'click',
        hidePopup
    );

    popup?.addEventListener('click', (event) => {
        if (event.target === popup) {
            hidePopup();
        }
    });

    accountForm?.addEventListener(
        'submit',
        (event) => {
            event.preventDefault();

            state.account = {
                name: accountForm
                    .querySelector('[name="name"]')
                    .value
                    .trim(),

                company: accountForm
                    .querySelector('[name="company"]')
                    .value
                    .trim(),

                phone: accountForm
                    .querySelector('[name="phone"]')
                    .value
                    .trim(),

                email: accountForm
                    .querySelector('[name="email"]')
                    .value
                    .trim(),
            };

            saveState();

            hideDrawer();

            showPopup(
                'Compte enregistré',
                'Les informations du compte ont été enregistrées.'
            );
        }
    );

    settingsForm?.addEventListener(
        'submit',
        (event) => {
            event.preventDefault();

            state.settings = {
                theme: settingsForm
                    .querySelector('[name="theme"]')
                    .value,

                density: settingsForm
                    .querySelector('[name="density"]')
                    .value,

                animation: settingsForm
                    .querySelector('[name="animation"]')
                    .value,
            };

            saveState();

            applyPreferences();

            hideDrawer();

            showPopup(
                'Paramètres enregistrés',
                'Les préférences d’affichage ont bien été prises en compte.'
            );
        }
    );

    applyPreferences();

    activateSection(state.activeSection);
}

function initializeExampleCinema() {
    const page = document.querySelector(
        '[data-example-cinema]'
    );

    if (
        !page ||
        page.dataset.exampleCinemaBound === 'true'
    ) {
        return;
    }

    page.dataset.exampleCinemaBound = 'true';

    const scenes = Array.from(
        page.querySelectorAll('[data-cinema-scene]')
    );

    const links = Array.from(
        page.querySelectorAll('[data-cinema-link]')
    );

    if (!scenes.length || !links.length) {
        return;
    }

    let activeIndex = 0;
    let isScrolling = false;
    let animationFrame = null;

    const duration = 500;

    const updateActiveLink = (index) => {
        activeIndex = Math.max(
            0,
            Math.min(index, scenes.length - 1)
        );

        links.forEach((link, linkIndex) => {
            const isActive =
                linkIndex === activeIndex;

            link.classList.toggle(
                'is-active',
                isActive
            );

            link.setAttribute(
                'aria-current',
                isActive ? 'true' : 'false'
            );
        });
    };

    const getScenePosition = (scene) => {
        return (
            window.scrollY +
            scene.getBoundingClientRect().top
        );
    };

    const animateScrollTo = (targetPosition) => {
        if (animationFrame !== null) {
            window.cancelAnimationFrame(
                animationFrame
            );
        }

        const startPosition = window.scrollY;
        const distance =
            targetPosition - startPosition;

        const startTime = performance.now();

        const easeInOut = (progress) => {
            return progress < 0.5
                ? 2 * progress * progress
                : 1 -
                    Math.pow(
                        -2 * progress + 2,
                        2
                    ) /
                        2;
        };

        const animate = (currentTime) => {
            const elapsed =
                currentTime - startTime;

            const progress = Math.min(
                elapsed / duration,
                1
            );

            const easedProgress =
                easeInOut(progress);

            window.scrollTo(
                0,
                startPosition +
                    distance *
                        easedProgress
            );

            if (progress < 1) {
                animationFrame =
                    window.requestAnimationFrame(
                        animate
                    );

                return;
            }

            animationFrame = null;
            isScrolling = false;

            window.scrollTo(
                0,
                targetPosition
            );
        };

        animationFrame =
            window.requestAnimationFrame(
                animate
            );
    };

    const goToScene = (index) => {
        if (isScrolling) {
            return;
        }

        const targetIndex = Math.max(
            0,
            Math.min(
                index,
                scenes.length - 1
            )
        );

        if (targetIndex === activeIndex) {
            return;
        }

        const targetScene =
            scenes[targetIndex];

        if (!targetScene) {
            return;
        }

        const targetPosition =
            getScenePosition(targetScene);

        isScrolling = true;

        updateActiveLink(targetIndex);

        animateScrollTo(
            targetPosition
        );
    };

    window.addEventListener(
        'wheel',
        (event) => {
            if (
                Math.abs(event.deltaY) < 8
            ) {
                return;
            }

            event.preventDefault();

            if (isScrolling) {
                return;
            }

            if (event.deltaY > 0) {
                goToScene(
                    activeIndex + 1
                );
            } else {
                goToScene(
                    activeIndex - 1
                );
            }
        },
        {
            passive: false,
        }
    );

    links.forEach((link, index) => {
        link.addEventListener(
            'click',
            (event) => {
                event.preventDefault();

                goToScene(index);
            }
        );
    });

    const initialPosition =
        window.scrollY;

    let closestIndex = 0;
    let closestDistance = Infinity;

    scenes.forEach((scene, index) => {
        const distance = Math.abs(
            getScenePosition(scene) -
                initialPosition
        );

        if (
            distance <
            closestDistance
        ) {
            closestDistance = distance;
            closestIndex = index;
        }
    });

    updateActiveLink(
        closestIndex
    );
}

document.addEventListener(
    'DOMContentLoaded',
    initializeHomePageInteractions
);

document.addEventListener(
    'turbo:load',
    initializeHomePageInteractions
);

document.addEventListener(
    'DOMContentLoaded',
    restorePagePosition
);

document.addEventListener(
    'turbo:load',
    restorePagePosition
);

document.addEventListener(
    'DOMContentLoaded',
    initializeExampleGrid
);

document.addEventListener(
    'turbo:load',
    initializeExampleGrid
);

document.addEventListener(
    'DOMContentLoaded',
    initializeExampleDashboard
);

document.addEventListener(
    'turbo:load',
    initializeExampleDashboard
);

document.addEventListener(
    'DOMContentLoaded',
    initializeExampleCinema
);

document.addEventListener(
    'turbo:load',
    initializeExampleCinema
);
