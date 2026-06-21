git add assets\images\clients\christophe-kippelen.png assets\images\clients\le-phare.png assets\styles\app.css
git commit -m "Add client logo assets and styles"
timeout /t 60 /nobreak >nul
git add src\Controller\HomePageController.php templates\home_page\index.html.twig
git commit -m "Improve the home page with hardcoded client highlights"
timeout /t 1 /nobreak >nul
git add src\Controller\ClientsController.php templates\clients\index.html.twig
git commit -m "Add hardcoded client cards with service placeholders"
timeout /t 1 /nobreak >nul
git add src\Controller\ServicesController.php templates\services\index.html.twig templates\services\request.html.twig templates\_partials\menu.html.twig
git commit -m "Improve service flows and link the new request page"
timeout /t 1 /nobreak >nul
git add src\Controller\DashboardController.php templates\dashboard\index.html.twig templates\dashboard\contacts.html.twig templates\dashboard\web_creation_requests.html.twig templates\dashboard\accessibility_consulting_requests.html.twig
git commit -m "Add a dashboard to review and process incoming requests"
