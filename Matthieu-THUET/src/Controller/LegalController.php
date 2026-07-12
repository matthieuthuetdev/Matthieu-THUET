<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LegalController extends AbstractController
{
    #[Route('/mentions-legales', name: 'app_legal_mentions')]
    public function mentions(): Response
    {
        return $this->render('legal/show.html.twig', [
            'document' => $this->buildDocument('mentions'),
        ]);
    }

    #[Route('/politique-de-confidentialite', name: 'app_legal_privacy')]
    public function privacy(): Response
    {
        return $this->render('legal/show.html.twig', [
            'document' => $this->buildDocument('privacy'),
        ]);
    }

    #[Route('/conditions-generales-de-vente', name: 'app_legal_terms')]
    public function terms(): Response
    {
        return $this->render('legal/show.html.twig', [
            'document' => $this->buildDocument('terms'),
        ]);
    }

    private function buildDocument(string $key): array
    {
        $documents = $this->getDocuments();
        $document = $documents[$key] ?? null;

        if ($document === null) {
            throw $this->createNotFoundException();
        }

        return [
            'title' => $document['title'],
            'summary' => $document['summary'],
            'updatedAt' => $document['updatedAt'],
            'readingTime' => $document['readingTime'],
            'sections' => $this->extractSections($document['body'], $key === 'terms'),
        ];
    }

    /**
     * @return array<string, array{title: string, summary: string, updatedAt: string, readingTime: string, body: string}>
     */
    private function getDocuments(): array
    {
        return [
            'mentions' => [
                'title' => 'Mentions légales',
                'summary' => 'Les informations d’identification de l’éditeur du site, de l’hébergeur et les règles générales d’utilisation du site.',
                'updatedAt' => '11 juillet 2026',
                'readingTime' => '5 min',
                'body' => <<<'TEXT'
1. Éditeur du site

Le présent site est édité par :

Matthieu THUET EI

Entrepreneur Individuel

Activité principale :

Développement web et consulting en accessibilité numérique

Code APE :

6201Z – Programmation informatique

SIREN :

102 926 326

SIRET :

102 926 326 00012

TVA :

TVA non applicable, article 293 B du Code général des impôts.

Adresse :

11 rue du Mittelbach

68100 Mulhouse

France

Téléphone :

+33 6 27 20 95 92

Adresse électronique :

contact@matthieuthuet.com

Site internet :

https://matthieuthuet.com

Directeur de la publication :

Matthieu THUET

2. Hébergement

Le site est hébergé par :

o2switch

Chemin des Pardiaux

63000 Clermont-Ferrand

France

Téléphone :

04 44 44 60 40

Site internet :

https://www.o2switch.fr

3. Activité

Matthieu THUET EI propose notamment les prestations suivantes :

création de sites internet sur mesure ;
refonte de sites internet ;
développement d'applications web ;
développement PHP ;
développement Symfony ;
développement WordPress ;
consulting en accessibilité numérique ;
audits d'accessibilité (RGAA / WCAG) ;
maintenance de sites internet ;
hébergement ;
gestion de noms de domaine ;
accompagnement technique ;
formation à l'utilisation des solutions développées.

Cette liste est donnée à titre indicatif et peut évoluer.

4. Propriété intellectuelle

L'ensemble du contenu présent sur le site matthieuthuet.com, notamment :

les textes ;
les photographies ;
les illustrations ;
les logos ;
les icônes ;
les graphismes ;
les vidéos ;
les documents téléchargeables ;
le code source développé spécifiquement pour le site ;

est protégé par les dispositions du Code de la propriété intellectuelle.

Toute reproduction, représentation, diffusion, modification ou exploitation, totale ou partielle, sans autorisation écrite préalable de Matthieu THUET est interdite.

5. Crédits

Le site internet a été entièrement conçu et développé par :

Matthieu THUET EI

Les illustrations, photographies, icônes et autres éléments graphiques présents sur le site sont :

soit des créations originales réalisées par Matthieu THUET EI ;
soit utilisés avec les autorisations, licences ou droits nécessaires.

6. Responsabilité

Matthieu THUET EI met tout en œuvre afin d'assurer l'exactitude des informations publiées sur le site.

Toutefois, certaines informations peuvent évoluer ou comporter des erreurs involontaires.

L'utilisateur demeure seul responsable de l'utilisation qu'il fait des informations présentes sur le site.

Matthieu THUET EI ne pourra être tenu responsable des dommages directs ou indirects résultant de l'utilisation du site.

7. Disponibilité

Le site est accessible 24 heures sur 24 et 7 jours sur 7, sauf interruption nécessaire notamment pour :

la maintenance ;
les mises à jour ;
les opérations techniques ;
les cas de force majeure.

Matthieu THUET EI ne saurait être tenu responsable d'une indisponibilité temporaire du site.

8. Liens hypertextes

Le site peut contenir des liens vers des sites internet de tiers.

Ces liens sont proposés uniquement à titre informatif.

Matthieu THUET EI n'exerce aucun contrôle sur ces sites et ne peut être tenu responsable de leur contenu, de leur fonctionnement ou de leur politique de confidentialité.

9. Données personnelles

Les traitements de données personnelles réalisés sur le site sont décrits dans la Politique de confidentialité, accessible à tout moment depuis le site.

10. Cookies

Le site utilise uniquement les cookies strictement nécessaires à son fonctionnement.

À ce jour, aucun cookie publicitaire, de profilage ou de mesure d'audience n'est utilisé.

Pour plus d'informations, l'utilisateur est invité à consulter la Politique de confidentialité.

11. Droit applicable

Les présentes mentions légales sont régies par le droit français.

En cas de litige, et à défaut de résolution amiable, les juridictions françaises seront seules compétentes, sous réserve des dispositions légales applicables.

12. Contact

Pour toute question concernant le site ou son contenu, vous pouvez contacter :

Matthieu THUET EI

📧 contact@matthieuthuet.com

📞 +33 6 27 20 95 92
TEXT,
            ],
            'privacy' => [
                'title' => 'Politique de confidentialité',
                'summary' => 'La manière dont les données personnelles sont collectées, utilisées, conservées et protégées sur le site.',
                'updatedAt' => '11 juillet 2026',
                'readingTime' => '6 min',
                'body' => <<<'TEXT'
1. Préambule

La présente Politique de confidentialité a pour objet d'informer les utilisateurs du site matthieuthuet.com sur la manière dont leurs données personnelles sont collectées, utilisées, conservées et protégées.

Matthieu THUET EI accorde une importance particulière au respect de la vie privée ainsi qu'à la protection des données personnelles conformément au Règlement Général sur la Protection des Données (RGPD) et à la loi Informatique et Libertés.

2. Responsable du traitement

Le responsable du traitement des données personnelles est :

Matthieu THUET EI

Entrepreneur Individuel

SIREN : 102 926 326

11 rue du Mittelbach

68100 Mulhouse

France

E-mail :

contact@matthieuthuet.com

Téléphone :

+33 6 27 20 95 92

3. Données collectées

Le site ne collecte des données personnelles que lorsque l'utilisateur les transmet volontairement via le formulaire de contact.

Les données pouvant être collectées sont :

Prénom ;
Nom ;
Nom de l'entreprise (facultatif) ;
Adresse e-mail ;
Sujet de la demande ;
Message ;
Acceptation de la présente Politique de confidentialité.

Aucune autre donnée personnelle n'est collectée volontairement par le site.

4. Finalités du traitement

Les données collectées sont utilisées uniquement afin de :

répondre aux demandes envoyées via le formulaire de contact ;
échanger avec le client au sujet de sa demande ;
assurer le suivi des échanges ;
préparer une éventuelle prestation lorsque cela est nécessaire ;
envoyer un accusé de réception automatique confirmant la bonne réception du message.

Les données ne sont jamais utilisées à des fins publicitaires.

5. Base juridique du traitement

Les traitements sont fondés sur :

le consentement de l'utilisateur lorsqu'il complète le formulaire de contact ;
l'exécution de mesures précontractuelles lorsqu'un utilisateur sollicite une prestation.

6. Destinataires des données

Les informations transmises via le formulaire de contact sont exclusivement destinées à Matthieu THUET EI.

Les messages sont envoyés vers l'adresse :

contact@matthieuthuet.com

Cette adresse est hébergée chez o2switch puis consultée via une liaison avec un compte Gmail afin de faciliter le traitement des demandes.

Aucune donnée n'est vendue, louée ou cédée à des tiers.

7. Durée de conservation

Les messages reçus via le formulaire de contact sont conservés pendant une durée de six (6) mois après la fin des échanges.

À l'issue de cette période, ils sont supprimés, sauf obligation légale contraire.

8. Sécurité des données

Matthieu THUET EI met en œuvre des mesures techniques et organisationnelles raisonnables afin d'assurer la confidentialité et la sécurité des données personnelles.

Toutefois, aucun système informatique ne pouvant garantir une sécurité absolue, une part de risque demeure inhérente à l'utilisation d'Internet.

9. Cookies

Le site utilise uniquement les cookies strictement nécessaires à son fonctionnement.

Il peut notamment s'agir :

d'un cookie de session Symfony ;
des cookies techniques nécessaires au fonctionnement du formulaire de contact.

Ces cookies ne permettent pas de réaliser un suivi publicitaire.

Le site n'utilise actuellement :

aucun cookie publicitaire ;
aucun cookie de mesure d'audience ;
aucun cookie de profilage.

10. Journaux techniques (logs)

Comme la plupart des serveurs web, l'hébergeur peut enregistrer automatiquement certaines informations techniques lors de la consultation du site.

Ces informations peuvent notamment comprendre :

l'adresse IP ;
la date et l'heure de la connexion ;
les pages consultées ;
le navigateur utilisé ;
le système d'exploitation.

Ces journaux sont utilisés exclusivement pour assurer la sécurité, la maintenance et le bon fonctionnement des services.

11. Hébergement

Le site est hébergé par :

o2switch

Chemin des Pardiaux

63000 Clermont-Ferrand

France

Site internet :

https://www.o2switch.fr

12. Vos droits

Conformément au RGPD, vous disposez notamment des droits suivants :

droit d'accès ;
droit de rectification ;
droit à l'effacement ;
droit à la limitation du traitement ;
droit d'opposition ;
droit à la portabilité de vos données.

Vous pouvez exercer ces droits en écrivant à :

contact@matthieuthuet.com

Une réponse vous sera apportée dans les meilleurs délais et au plus tard dans le délai prévu par la réglementation.

13. Réclamation

Si vous estimez que vos droits ne sont pas respectés, vous pouvez adresser une réclamation auprès de :

Commission Nationale de l'Informatique et des Libertés (CNIL)

3 Place de Fontenoy

TSA 80715

75334 Paris Cedex 07

France

Site internet :

https://www.cnil.fr

14. Modification de la présente politique

La présente Politique de confidentialité peut être modifiée à tout moment afin de tenir compte des évolutions légales, réglementaires ou techniques.

La version applicable est celle publiée sur le site matthieuthuet.com à la date de la consultation.
TEXT,
            ],
            'terms' => [
                'title' => 'Conditions Générales de Vente',
                'summary' => 'Les règles contractuelles applicables aux prestations proposées, notamment les responsabilités, garanties et modalités de règlement des litiges.',
                'updatedAt' => '11 juillet 2026',
                'readingTime' => '8 min',
                'body' => <<<'TEXT'
Préambule

Les présentes Conditions Générales de Vente (ci-après « les CGV ») définissent les droits et obligations de Matthieu THUET EI, entrepreneur individuel spécialisé dans le développement web et le consulting en accessibilité numérique, ainsi que ceux de ses clients.

L'objectif de ces conditions est d'assurer une relation de travail claire, transparente et équilibrée entre le prestataire et ses clients.

Chaque projet est réalisé sur mesure afin de répondre aux besoins exprimés par le client. Une attention particulière est portée à la qualité du code, à l'accessibilité numérique, à la sécurité, aux performances ainsi qu'à l'accompagnement du client tout au long du projet.

Les présentes CGV sont accessibles à tout moment sur le site matthieuthuet.com et peuvent être communiquées sur simple demande.

Toute commande implique l'acceptation pleine et entière des présentes Conditions Générales de Vente.

Article 1 – Identification du prestataire

Les prestations sont réalisées par :

**Matthieu THUET EI**

Entrepreneur Individuel

Activité principale :

Développement web - Consulting en accessibilité web

Profession libérale non réglementée

Code APE :

6201Z – Programmation informatique

Immatriculation au Registre National des Entreprises (RNE) :

26 mars 2026

SIREN :

102 926 326

SIRET :

102 926 326 00012

TVA :

TVA non applicable, article 293 B du Code général des impôts.

Adresse :

11 rue du Mittelbach

68100 Mulhouse

France

Téléphone :

+33 6 27 20 95 92

Adresse électronique :

[contact@matthieuthuet.com](mailto:contact@matthieuthuet.com)

Site internet :

[https://matthieuthuet.com](https://matthieuthuet.com)

Article 2 – Objet

Les présentes Conditions Générales de Vente ont pour objet de définir les modalités selon lesquelles Matthieu THUET EI réalise les prestations commandées par ses clients.

Elles s'appliquent à l'ensemble des prestations proposées, sauf accord écrit particulier conclu entre les parties.

Toute clause contraire émise par le client est réputée non écrite, sauf acceptation écrite et expresse de Matthieu THUET EI.

Article 3 – Champ d'application

Les présentes CGV s'appliquent à toute prestation réalisée par Matthieu THUET EI, qu'elle soit conclue avec :

* un particulier ;
* une entreprise ;
* une association ;
* une collectivité ;
* un travailleur indépendant ;
* toute autre personne morale ou physique.

Le client reconnaît avoir pris connaissance des présentes Conditions Générales de Vente avant la validation de sa commande.

La signature d'un devis vaut acceptation sans réserve des présentes CGV.

Article 4 – Définitions

Dans les présentes Conditions Générales de Vente, les termes suivants désignent :

**Prestataire**

Matthieu THUET EI.

**Client**

Toute personne physique ou morale commandant une prestation auprès du prestataire.

**Projet**

Toute prestation faisant l'objet d'un devis accepté.

**Maintenance**

Ensemble des prestations destinées à assurer le bon fonctionnement, les mises à jour, les sauvegardes et les corrections prévues au contrat.

**Site internet**

Ensemble des fichiers, bases de données, contenus et développements réalisés dans le cadre d'un projet.

**Livraison**

Moment auquel les prestations prévues au devis sont terminées et mises à disposition du client conformément aux présentes CGV.

Article 5 – Prestations proposées

Matthieu THUET EI propose notamment les prestations suivantes :

* création de sites internet sur mesure ;
* refonte de sites internet existants ;
* développement d'applications web ;
* développement PHP ;
* développement Symfony ;
* développement WordPress ;
* consulting en accessibilité numérique ;
* audits d'accessibilité selon les référentiels RGAA et WCAG ;
* accompagnement à la mise en conformité ;
* maintenance évolutive et corrective des sites réalisés ;
* hébergement de sites internet ;
* gestion des noms de domaine ;
* optimisation du référencement naturel (SEO) dans la limite des bonnes pratiques connues au moment de la prestation ;
* accompagnement technique ;
* formation du client à l'utilisation des outils développés lorsque cette prestation est prévue dans le devis.

Cette liste est non exhaustive.

Le prestataire se réserve le droit de proposer toute autre prestation entrant dans son domaine de compétences.

Article 6 – Processus de commande

Toute prestation débute par une phase d'échange permettant d'identifier précisément les besoins du client.

Le déroulement habituel d'un projet est le suivant :

## Création ou refonte d'un site internet

1. Prise de contact.
2. Analyse des besoins du client.
3. Élaboration d'un devis détaillé accompagné d'un planning prévisionnel.
4. Signature du devis par le client.
5. Versement de l'acompte lorsqu'il est applicable.
6. Développement du projet avec des points d'avancement réguliers.
7. Validation progressive des différentes étapes du projet.
8. Livraison du projet.
9. Accompagnement et maintenance lorsque cette prestation a été souscrite.

## Audit d'accessibilité

Le déroulement d'un audit est généralement le suivant :

1. Analyse du site internet ou de l'application.
2. Identification des non-conformités.
3. Évaluation de leur impact sur l'accessibilité.
4. Rédaction d'un rapport détaillé précisant les priorités de correction.
5. Accompagnement du client dans la mise en conformité lorsqu'il le souhaite.

Le prestataire reste libre d'adapter ce déroulement en fonction des spécificités du projet.

Article 7 – Devis

Toute prestation fait l'objet d'un devis détaillé.

Les devis sont établis gratuitement.

Sauf mention contraire, ils demeurent valables pendant une durée de **trente (30) jours** à compter de leur date d'émission.

Le devis précise notamment :

* la nature des prestations ;
* le prix ;
* les modalités de paiement ;
* les délais prévisionnels ;
* les éventuelles prestations complémentaires.

Le devis est réputé accepté uniquement après :

* sa signature par le client ;
* l'acceptation des présentes Conditions Générales de Vente ;
* le versement de l'acompte lorsqu'il est prévu.

Un simple échange par courrier électronique ou par téléphone ne vaut pas acceptation du devis.

Toute modification importante du projet après validation du devis fera l'objet d'un nouveau devis.

Article 8 – Tarification

Les prestations sont réalisées selon un tarif forfaitaire.

Chaque devis est établi en fonction notamment :

* des besoins exprimés par le client ;
* de la complexité du projet ;
* du temps de réalisation estimé ;
* des technologies utilisées ;
* des prestations complémentaires demandées.

Les tarifs sont exprimés en euros.

En raison du régime fiscal de l'entreprise, la TVA n'est pas applicable conformément à l'article 293 B du Code général des impôts.

Les tarifs indiqués dans le devis demeurent valables uniquement pour les prestations qui y sont décrites.

Toute demande supplémentaire pourra faire l'objet d'une nouvelle facturation.

Article 9 – Acompte

Pour toute prestation de création ou de refonte de site internet, un acompte correspondant à **30 %** du montant total du devis est demandé avant le début des travaux.

Aucun développement ne débute avant la réception effective de cet acompte.

Les prestations de consulting et d'audit d'accessibilité ne nécessitent pas le versement d'un acompte, sauf mention contraire figurant sur le devis.

En cas d'annulation du projet par le client après le versement de l'acompte, celui-ci reste acquis à Matthieu THUET EI.

Cet acompte a notamment pour objet de couvrir :

* le temps consacré à l'étude du projet ;
* les travaux préparatoires ;
* la réservation du planning ;
* les premières opérations de développement éventuellement réalisées.

Article 10 – Modalités de paiement

Les règlements s'effectuent exclusivement par **virement bancaire**.

Sauf disposition particulière figurant sur le devis, les factures sont payables dans un délai maximal de **trente (30) jours** à compter de leur date d'émission.

Le paiement est réputé effectué uniquement après encaissement effectif des sommes dues.

Le prestataire se réserve le droit de suspendre toute prestation en cas de retard de paiement.

Article 11 – Retard de paiement

En cas de retard de paiement, les pénalités prévues par la réglementation en vigueur sont automatiquement applicables.

Pour les clients professionnels, une indemnité forfaitaire pour frais de recouvrement pourra également être exigée conformément aux dispositions de l'article L.441-10 du Code de commerce.

Le retard de paiement peut entraîner la suspension des prestations en cours jusqu'à régularisation complète de la situation.

Le prestataire se réserve également le droit de suspendre temporairement certains services, notamment la maintenance, tant que les sommes dues n'ont pas été intégralement réglées.

Article 12 – Modification du projet

Le devis est établi sur la base des besoins exprimés par le client au moment de sa signature.

Toute demande de modification importante portant notamment sur :

* les fonctionnalités ;
* le design ;
* l'architecture du projet ;
* les technologies utilisées ;
* les objectifs initiaux ;

pourra donner lieu à un nouveau devis.

Les travaux supplémentaires ne débuteront qu'après acceptation de celui-ci.

Les modifications mineures pourront être réalisées sans nouveau devis lorsqu'elles restent compatibles avec le périmètre initial du projet.

Article 13 – Obligations du client

Le client s'engage à collaborer activement avec le prestataire afin de permettre la bonne réalisation du projet.

À ce titre, il s'engage notamment à :

* fournir l'ensemble des informations nécessaires à la réalisation du projet ;
* transmettre les textes, images, vidéos, logos et autres contenus dans les délais convenus ;
* garantir qu'il dispose des droits nécessaires pour utiliser les contenus transmis au prestataire ;
* communiquer les accès techniques éventuellement nécessaires à la réalisation de la prestation ;
* répondre aux demandes d'informations dans des délais raisonnables ;
* valider les différentes étapes du projet.

Le client est seul responsable de l'exactitude, de la légalité et de la conformité des contenus qu'il fournit.

Le prestataire ne pourra être tenu responsable d'un retard de livraison résultant d'un manquement du client à ses obligations.

Article 14 – Collaboration entre les parties

La réussite d'un projet repose sur une collaboration active entre le client et le prestataire.

Le client s'engage à maintenir des échanges réguliers avec le prestataire pendant toute la durée du projet.

Les délais de réalisation sont suspendus lorsque le prestataire est dans l'attente :

* d'une validation ;
* d'un contenu ;
* d'un document ;
* d'un accès ;
* ou de tout autre élément indispensable à la poursuite du projet.

Le prestataire ne pourra être tenu responsable des retards résultant d'un manque de réactivité du client.

Article 15 – Validation des étapes

Afin d'assurer le bon déroulement du projet, certaines étapes pourront faire l'objet d'une validation par le client.

Il peut notamment s'agir :

* de la maquette graphique ;
* de l'identité visuelle ;
* des fonctionnalités ;
* de l'arborescence ;
* des contenus ;
* de la recette finale.

Une fois une étape validée, elle est réputée acceptée.

Toute demande de modification importante portant sur une étape déjà validée pourra faire l'objet d'un nouveau devis.

Les corrections mineures demeurent possibles lorsqu'elles restent compatibles avec le périmètre initial du projet.

Article 16 – Suspension d'un projet

Le prestataire peut suspendre temporairement un projet lorsque le client ne fournit pas les éléments indispensables à sa réalisation.

La suspension peut notamment intervenir en cas :

* d'absence prolongée de réponse ;
* d'absence de validation ;
* de non-transmission des contenus ;
* de non-paiement d'une facture.

Pendant cette période, les délais de livraison sont automatiquement suspendus.

Article 17 – Abandon d'un projet

En l'absence de réponse du client pendant une durée de **six (6) mois**, malgré une ou plusieurs relances, le projet sera considéré comme abandonné.

Toute reprise du projet fera l'objet :

* d'un nouveau devis ;
* d'un nouveau planning ;
* d'un nouvel acompte lorsque celui-ci est applicable.

L'acompte précédemment versé reste acquis au prestataire.

Le prestataire ne peut garantir la disponibilité des technologies, tarifs ou délais initialement prévus lors de la reprise du projet.

Article 18 – Livraison

Le projet est considéré comme livré lorsque :

* l'ensemble des prestations prévues au devis a été réalisé ;
* le site est fonctionnel conformément au devis accepté ;
* les éventuelles anomalies bloquantes ont été corrigées.

Lorsque le client a choisi l'hébergement proposé par Matthieu THUET EI, le site est mis en ligne directement sur son espace d'hébergement.

Dans les autres cas, le projet est livré sous la forme :

* d'un dépôt Git ;
* ou d'une archive contenant les fichiers nécessaires à son fonctionnement.

La livraison définitive intervient après règlement intégral des sommes dues.

Article 19 – Remise des accès et du code source

Après paiement intégral des prestations, le client peut obtenir, sur simple demande :

* le code source du projet ;
* les fichiers du site ;
* les bases de données nécessaires ;
* les accès administrateur du site, lorsque ceux-ci existent.

Lorsque le client dispose de son propre hébergement, les accès à celui-ci lui appartiennent.

Pendant toute la durée d'un contrat de maintenance, Matthieu THUET EI peut conserver les accès techniques nécessaires afin d'assurer correctement les prestations prévues au contrat.

Le client peut récupérer l'ensemble de ces accès à tout moment sur simple demande.

Toute intervention technique réalisée directement par le client ou par un tiers sans l'accord préalable du prestataire pourra entraîner la suspension des garanties et des prestations de maintenance jusqu'à vérification complète du bon fonctionnement du site.

Article 20 – Garantie

Pendant une durée de **six (6) mois** suivant la livraison, le prestataire s'engage à corriger gratuitement les anomalies résultant directement des développements réalisés dans le cadre du projet.

Cette garantie couvre uniquement les anomalies empêchant le fonctionnement normal des fonctionnalités prévues au devis.

La garantie ne couvre notamment pas :

* les nouvelles fonctionnalités ;
* les évolutions du projet ;
* les modifications demandées après validation du projet ;
* les modifications réalisées par le client ou par un tiers ;
* les erreurs provoquées par une mauvaise utilisation du site ;
* les problèmes liés à l'hébergement choisi par le client ;
* les évolutions des navigateurs, des systèmes d'exploitation ou des services tiers.

Les mises à jour de sécurité ne sont comprises que dans le cadre d'un contrat de maintenance.

Article 21 – Maintenance

La maintenance constitue une prestation distincte de la création du site.

Elle fait l'objet d'un contrat spécifique.

Elle est proposée sous la forme d'un **abonnement annuel**.

Sauf mention contraire dans le contrat de maintenance, celle-ci comprend notamment :

* les mises à jour techniques du site ;
* les mises à jour de sécurité ;
* les sauvegardes régulières ;
* la correction des anomalies couvertes par le contrat ;
* les modifications mineures demandées par le client ;
* l'assistance technique par courrier électronique.

Les demandes dépassant le périmètre de la maintenance feront l'objet d'un devis complémentaire.

Le support est assuré du **lundi au vendredi**, de **8 h 00 à 18 h 00**.

Les demandes sont traitées dans un délai indicatif de **24 à 48 heures ouvrées**.

Le contrat de maintenance peut être renouvelé selon les conditions prévues au contrat spécifique conclu entre les parties.

Article 22 – Hébergement

Le client demeure propriétaire de son hébergement ainsi que du nom de domaine associé à son projet.

Afin de garantir un niveau de qualité, de sécurité et de disponibilité conforme aux prestations proposées, Matthieu THUET EI recommande l'utilisation de l'hébergeur **o2switch**.

Lorsque le client choisit l'hébergement proposé par le prestataire, celui-ci procède notamment à :

* la configuration de l'hébergement ;
* l'installation du site ;
* la configuration de la base de données ;
* la mise en ligne du projet ;
* la configuration des certificats SSL lorsque cela est applicable.

Lorsque le client choisit un hébergeur différent, le prestataire livre le projet conformément aux modalités prévues au devis.

La mise en ligne sur un hébergement tiers peut être réalisée sur demande et fera l'objet d'un devis complémentaire.

Le prestataire n'assure aucune prestation de maintenance ou de support sur un hébergement non validé dans le cadre du contrat de maintenance.

Article 23 – Nom de domaine

Le nom de domaine est enregistré au nom du client.

Lorsque Matthieu THUET EI réalise les démarches administratives liées à son enregistrement, il agit exclusivement pour le compte du client.

Le client demeure seul propriétaire du nom de domaine.

Le renouvellement du nom de domaine relève de la responsabilité du client, sauf si une prestation spécifique de gestion a été souscrite.

Article 24 – Sauvegardes

Pendant toute la durée du contrat de maintenance, Matthieu THUET EI réalise des sauvegardes régulières du site internet.

Ces sauvegardes permettent notamment de restaurer le site en cas d'incident technique relevant du périmètre du contrat de maintenance.

À la fin du contrat de maintenance, une sauvegarde complète du site est remise au client.

À compter de cette remise, le client devient seul responsable de la conservation de ses sauvegardes.

Le prestataire ne pourra être tenu responsable d'une perte de données postérieure à la fin du contrat de maintenance.

Article 25 – Administration technique

Pendant toute la durée du contrat de maintenance, Matthieu THUET EI assure l'administration technique du site internet.

À ce titre, il peut disposer des accès nécessaires notamment :

* à l'hébergement ;
* aux bases de données ;
* aux accès FTP ou SFTP ;
* aux outils d'administration du site.

Le client conserve la propriété de ces accès et peut les récupérer à tout moment sur simple demande.

Afin de garantir la stabilité et la sécurité du site, le client s'engage à ne pas modifier lui-même la configuration technique de l'hébergement sans l'accord préalable du prestataire.

Toute intervention réalisée directement par le client ou par un tiers pourra entraîner la suspension de la garantie ainsi que des prestations de maintenance jusqu'à vérification complète du bon fonctionnement du site.

Article 26 – Référencement naturel (SEO)

Lorsque le devis prévoit une prestation d'optimisation du référencement naturel, Matthieu THUET EI met en œuvre les bonnes pratiques connues au moment de la réalisation du projet.

Toutefois, le prestataire ne garantit ni un positionnement précis dans les moteurs de recherche, ni un volume minimal de visiteurs.

Les résultats du référencement dépendent notamment :

* des moteurs de recherche ;
* de la concurrence ;
* des contenus publiés ;
* des mises à jour des algorithmes ;
* des actions réalisées par le client après la livraison.

Le référencement constitue une obligation de moyens et non une obligation de résultat.

Article 27 – Accessibilité numérique

Les audits et prestations de conseil en accessibilité sont réalisés conformément aux référentiels applicables au moment de leur réalisation, notamment :

* le RGAA ;
* les WCAG.

Le prestataire s'engage à fournir une analyse sérieuse, documentée et conforme aux bonnes pratiques reconnues.

Toutefois, les évolutions réglementaires, les modifications apportées ultérieurement au site ou l'intervention de tiers peuvent remettre en cause le niveau de conformité obtenu.

Les prestations réalisées constituent une obligation de moyens et non une garantie permanente de conformité.

Article 28 – Utilisation de composants Open Source

Afin de garantir la qualité, la sécurité et la pérennité des projets réalisés, le prestataire est autorisé à utiliser des composants Open Source.

Il peut notamment s'agir :

* de frameworks ;
* de bibliothèques ;
* de CMS ;
* de dépendances ;
* d'outils de développement.

Ces composants demeurent soumis à leurs licences respectives.

Le client reconnaît que leur utilisation fait partie intégrante des bonnes pratiques actuelles du développement logiciel.

Article 29 – Services tiers

Le projet peut intégrer des services ou composants développés par des tiers.

Il peut notamment s'agir :

* d'API ;
* de services cloud ;
* de services d'envoi d'e-mails ;
* de systèmes de paiement ;
* de bibliothèques externes.

Le prestataire ne pourra être tenu responsable :

* d'une interruption de ces services ;
* d'une modification de leurs conditions d'utilisation ;
* d'une évolution de leurs fonctionnalités ;
* de leur suppression ;
* d'une augmentation de leurs tarifs.

Toute intervention rendue nécessaire par une évolution d'un service tiers pourra faire l'objet d'une nouvelle prestation.

Article 30 – Évolution des technologies

Le client reconnaît que les technologies du web évoluent en permanence.

Au fil du temps, certaines versions de logiciels, frameworks, bibliothèques ou navigateurs peuvent devenir obsolètes.

Le prestataire ne garantit pas la compatibilité permanente du projet avec les futures évolutions techniques indépendantes de sa volonté.

Les adaptations rendues nécessaires par ces évolutions pourront faire l'objet d'un nouveau devis.

Article 31 – Propriété intellectuelle

Sous réserve du paiement intégral des sommes dues, le client devient propriétaire des développements spécifiquement réalisés pour son projet.

Toutefois, Matthieu THUET EI conserve l'entière propriété :

* de son savoir-faire ;
* de ses méthodes de développement ;
* de ses outils internes ;
* de ses composants réutilisables ;
* de ses bibliothèques personnelles ;
* de ses modèles de développement.

Le client acquiert uniquement les droits nécessaires à l'exploitation du projet réalisé pour son propre usage.

Toute réutilisation des éléments appartenant au prestataire en dehors du projet livré est interdite sans autorisation préalable.

Article 32 – Confidentialité

Le prestataire s'engage à préserver la confidentialité des informations communiquées par le client dans le cadre de l'exécution des prestations.

Sont notamment concernées :

* les informations commerciales ;
* les informations techniques ;
* les données stratégiques ;
* les documents transmis par le client ;
* les accès informatiques ;
* toute information identifiée comme confidentielle.

Le prestataire s'engage à ne pas communiquer ces informations à des tiers sans l'accord préalable du client, sauf obligation légale ou nécessité technique liée à l'exécution de la prestation.

Cette obligation demeure applicable après la fin des prestations.

Article 33 – Références commerciales (Portfolio)

Sauf opposition écrite du client avant la livraison du projet, Matthieu THUET EI est autorisé à présenter les prestations réalisées à titre de référence professionnelle.

Cette présentation peut notamment comprendre :

* le nom du client ;
* le logo du client ;
* des captures d'écran du projet ;
* une description succincte des prestations réalisées ;
* un lien vers le site internet.

Aucune information confidentielle ne sera publiée sans l'accord préalable du client.

Article 34 – Responsabilité du client

Le client demeure seul responsable :

* des contenus qu'il fournit ;
* des droits d'auteur attachés à ces contenus ;
* des images, photographies, vidéos et illustrations utilisées ;
* des textes publiés ;
* des licences des polices de caractères qu'il fournit ;
* de la conformité des contenus à la réglementation applicable.

Le client garantit disposer de l'ensemble des autorisations nécessaires à l'utilisation des contenus transmis au prestataire.

En cas de réclamation d'un tiers résultant des contenus fournis par le client, la responsabilité du prestataire ne pourra être engagée.

Article 35 – Limitation de responsabilité

Le prestataire est tenu à une obligation de moyens.

Sa responsabilité ne pourra être engagée en cas de dommage résultant notamment :

* d'une mauvaise utilisation du site par le client ;
* d'une intervention réalisée par le client ou un tiers ;
* d'un dysfonctionnement de l'hébergement choisi par le client ;
* d'une interruption des réseaux Internet ;
* d'une panne électrique ;
* d'une cyberattaque visant un service tiers ;
* d'une indisponibilité d'une API ou d'un service externe ;
* d'une incompatibilité provoquée par une évolution indépendante de la volonté du prestataire ;
* d'un cas de force majeure.

Le prestataire ne pourra être tenu responsable des pertes indirectes, notamment :

* perte de chiffre d'affaires ;
* perte d'exploitation ;
* perte de clientèle ;
* perte d'image ;
* manque à gagner.

Sa responsabilité est, en tout état de cause, limitée au montant effectivement payé par le client au titre de la prestation concernée.

> **Petite précision :** cette dernière phrase est une clause classique. Elle est généralement admise en B2B, mais elle peut être discutée lorsqu'un consommateur est concerné. Je te la laisse car elle protège bien ton activité, mais elle ne doit pas priver un consommateur de droits prévus par la loi.

Article 36 – Force majeure

Aucune des parties ne pourra être tenue responsable d'un retard ou d'une inexécution résultant d'un cas de force majeure au sens de l'article 1218 du Code civil.

Sont notamment considérés comme des cas de force majeure :

* catastrophe naturelle ;
* incendie ;
* inondation ;
* guerre ;
* épidémie ;
* panne généralisée des réseaux de télécommunication ;
* coupure majeure d'électricité ;
* décision administrative empêchant temporairement l'exécution du contrat.

Pendant la durée du cas de force majeure, les obligations des parties sont suspendues.

Article 37 – Assurance

Matthieu THUET EI déclare être couvert par une assurance Responsabilité Civile Professionnelle adaptée à son activité.

À la date de publication des présentes CGV, cette assurance est souscrite auprès de **Hiscox**, par l'intermédiaire de **Orus France SAS**, et couvre les activités professionnelles exercées dans le cadre du présent contrat.

Le prestataire s'engage à maintenir une assurance adaptée pendant toute la durée de son activité.

Article 38 – Protection des données personnelles

Le traitement des données personnelles est régi par la Politique de confidentialité disponible sur le site **matthieuthuet.com**.

Les données collectées sont utilisées uniquement dans le cadre de la gestion des demandes, de l'exécution des prestations et du suivi de la relation avec le client.

Le client dispose des droits prévus par le Règlement Général sur la Protection des Données (RGPD), notamment des droits d'accès, de rectification, d'effacement, de limitation, d'opposition et de portabilité.

Toute demande peut être adressée à :

**[contact@matthieuthuet.com](mailto:contact@matthieuthuet.com)**

Article 39 – Droit de rétractation

Conformément aux dispositions du Code de la consommation, le client consommateur bénéficie d'un droit de rétractation lorsqu'il conclut un contrat à distance.

Toutefois, lorsqu'il demande expressément que l'exécution de la prestation commence avant l'expiration du délai légal de rétractation, il reconnaît que ce droit peut être perdu conformément aux dispositions légales applicables, notamment lorsque la prestation a été pleinement exécutée.

Les modalités d'exercice du droit de rétractation sont précisées, lorsque cela est applicable, dans le devis ou tout document contractuel remis au client.

Article 40 – Médiation de la consommation

En cas de litige, le client est invité à adresser en priorité une réclamation écrite à Matthieu THUET EI afin de rechercher une solution amiable.

À défaut d'accord amiable ou en l'absence de réponse dans un délai d'un (1) mois, le client consommateur peut saisir gratuitement le médiateur de la consommation compétent.

Le médiateur désigné est :

**Société Médiation Professionnelle**

Site internet :

[http://www.mediateur-consommation-smp.fr](http://www.mediateur-consommation-smp.fr)

Adresse :

Alteritae

5 rue Salvaing

12000 Rodez

Article 41 – Droit applicable

Les présentes Conditions Générales de Vente sont soumises au droit français.

Elles sont rédigées en langue française.

Article 42 – Règlement des litiges

Les parties s'efforceront de résoudre à l'amiable tout différend relatif à l'interprétation ou à l'exécution des présentes CGV.

À défaut d'accord amiable, le litige sera porté devant la juridiction territorialement compétente conformément aux règles de procédure applicables.

Article 43 – Modification des présentes CGV

Matthieu THUET EI se réserve le droit de modifier les présentes Conditions Générales de Vente à tout moment.

Les nouvelles conditions ne s'appliqueront qu'aux prestations conclues après leur entrée en vigueur.

La version applicable est celle en vigueur à la date de signature du devis.

Article 44 – Entrée en vigueur

Les présentes Conditions Générales de Vente entrent en vigueur à compter de leur date de publication sur le site **matthieuthuet.com**.

Elles demeurent applicables jusqu'à leur remplacement par une nouvelle version.
TEXT,
            ],
        ];
    }

    /**
     * @return array<int, array{title: string, contentHtml: string}>
     */
    private function extractSections(string $body, bool $isTerms): array
    {
        $pattern = $isTerms
            ? '/^(Préambule|Article\s+\d+\s+.+)$/m'
            : '/^(\d+\.\s+.+)$/m';

        $parts = preg_split($pattern, $body, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY) ?: [];

        if ($parts === []) {
            return [[
                'title' => 'Contenu',
                'contentHtml' => $this->formatRichText($body),
            ]];
        }

        $sections = [];
        $partsCount = count($parts);

        for ($index = 0; $index < $partsCount; $index += 2) {
            $sectionTitle = trim((string) ($parts[$index] ?? ''));
            $sectionContent = trim((string) ($parts[$index + 1] ?? ''));

            if ($sectionTitle === '') {
                continue;
            }

            $sections[] = [
                'title' => $sectionTitle,
                'contentHtml' => $this->formatRichText($sectionContent),
            ];
        }

        return $sections !== [] ? $sections : [[
            'title' => 'Contenu',
            'contentHtml' => $this->formatRichText($body),
        ]];
    }

    private function formatRichText(string $content): string
    {
        $lines = preg_split('/\n/', trim($content)) ?: [];
        $html = [];
        $paragraph = [];
        $listItems = [];
        $quoteLines = [];

        $flushParagraph = function () use (&$html, &$paragraph): void {
            if ($paragraph === []) {
                return;
            }

            $formattedLines = array_map(fn (string $line): string => $this->formatInlineText($line), $paragraph);
            $html[] = '<p>' . implode('<br>', $formattedLines) . '</p>';
            $paragraph = [];
        };

        $flushList = function () use (&$html, &$listItems): void {
            if ($listItems === []) {
                return;
            }

            $items = array_map(fn (string $item): string => '<li>' . $this->formatInlineText($item) . '</li>', $listItems);
            $html[] = '<ul>' . implode('', $items) . '</ul>';
            $listItems = [];
        };

        $flushQuote = function () use (&$html, &$quoteLines): void {
            if ($quoteLines === []) {
                return;
            }

            $formattedLines = array_map(fn (string $line): string => $this->formatInlineText($line), $quoteLines);
            $html[] = '<blockquote><p>' . implode('<br>', $formattedLines) . '</p></blockquote>';
            $quoteLines = [];
        };

        foreach ($lines as $line) {
            $trimmedLine = trim($line);

            if ($trimmedLine === '' || $trimmedLine === '---') {
                $flushParagraph();
                $flushList();
                $flushQuote();
                continue;
            }

            if (preg_match('/^#{1,6}\s+(.+)$/', $trimmedLine, $matches) === 1) {
                $flushParagraph();
                $flushList();
                $flushQuote();
                $html[] = '<h3>' . $this->formatInlineText($matches[1]) . '</h3>';
                continue;
            }

            if (preg_match('/^\*\s+(.+)$/', $trimmedLine, $matches) === 1) {
                $flushParagraph();
                $flushQuote();
                $listItems[] = $matches[1];
                continue;
            }

            if (preg_match('/^>\s*(.+)$/', $trimmedLine, $matches) === 1) {
                $flushParagraph();
                $flushList();
                $quoteLines[] = $matches[1];
                continue;
            }

            $flushList();
            $flushQuote();
            $paragraph[] = $trimmedLine;
        }

        $flushParagraph();
        $flushList();
        $flushQuote();

        return implode("\n", $html);
    }

    private function formatInlineText(string $text): string
    {
        $escaped = htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        $escaped = preg_replace_callback(
            '/\[(.+?)\]\((https?:\/\/[^\s)]+|mailto:[^)]+)\)/',
            static fn (array $matches): string => sprintf(
                '<a href="%s">%s</a>',
                htmlspecialchars($matches[2], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
                $matches[1]
            ),
            $escaped
        ) ?? $escaped;

        $escaped = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $escaped) ?? $escaped;

        return $escaped;
    }
}
