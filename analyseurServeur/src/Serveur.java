
import com.sun.net.httpserver.HttpExchange;
import com.sun.net.httpserver.HttpHandler;
import com.sun.net.httpserver.HttpServer;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.OutputStream;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.InetSocketAddress;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.concurrent.ThreadPoolExecutor;
import java.util.List;
import java.util.Map;
import java.util.ArrayList;
import java.util.UUID;
import java.util.concurrent.Executors;
import java.util.logging.Logger;







public class Serveur {
    // logger pour trace
    private static final Logger LOGGER = Logger.getLogger( Serveur.class.getName() );
    private static final String SERVEUR = "localhost"; // url de base du service
    private static final int PORT = 8001; // port serveur
    private static final String URL = "/projet/php"; // url de base du service
    // liste des chemins des fichiers envoyés par le client
    private static List<String> uploadedFiles = new ArrayList<>(); 

    // boucle principale qui lance le serveur sur le port 8001, à l'url test
    public static void main(String[] args) {
        HttpServer server = null;
        try {
            server = HttpServer.create(new InetSocketAddress(SERVEUR, PORT), 0);

            server.createContext(URL, new  MyHttpHandler());
            ThreadPoolExecutor threadPoolExecutor = (ThreadPoolExecutor) Executors.newFixedThreadPool(10);
            server.setExecutor(threadPoolExecutor);
            server.start();
            LOGGER.info(" Server started on port " + PORT);

        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    private static class MyHttpHandler implements HttpHandler {


        /**
         * Manage GET request param
         * @param httpExchange
         * @return first value
         */
        private String handleGetRequest(HttpExchange httpExchange) {
            return httpExchange.getRequestURI()
                    .toString()
                    .split("\\?")[1]
                    .split("=")[1];
        }


        /**
         * Gérer le corps de la requête POST
         * @param httpExchange : requête http
         * @return le corps de la requête
         */
        private String handlePostRequest(HttpExchange httpExchange) {
            try {
                InputStream inputStream = httpExchange.getRequestBody();
                BufferedReader reader = new BufferedReader(new InputStreamReader(inputStream));
                StringBuilder codeBuilder = new StringBuilder();
                String line;
                while ((line = reader.readLine()) != null) {
                    codeBuilder.append(line).append("\n");
                }

                String requestBody = codeBuilder.toString();

                
                // Vérifier si le corps de la requête est un fichier ou une liste de mots
                if (isFileRequest(requestBody)) {
                    // Corps de requête est un fichier
                    String pythonCode = requestBody;
                    LOGGER.info("Fichier reçu : " + pythonCode);
                    // Enregistrer le fichier sur le serveur dans un dossier temporaire
                    String fileName = "py/" + UUID.randomUUID().toString() + ".py";
                    // On enlève l'entête du fichier (ajoutée lors de l'envoi de la requête)
                    Files.write(Paths.get(fileName), pythonCode.getBytes());
                    
                    // Ajouter le chemin du fichier à la liste des fichiers envoyés 
                    uploadedFiles.add(fileName);

                    // Traiter le fichier python envoyé par le client et envoyer la réponse au client
                    String result = PythonCodeAnalyzer.analyzePythonCode(pythonCode);

                    return result;
                } else {
                    // Enlever le "mots=" du corps de la requête
                    requestBody = requestBody.substring(5);
                    // enlever le saut de ligne à la fin de requestBody
                    requestBody = requestBody.substring(0, requestBody.length() - 1);
                    // Corps de requête est une liste de mots
                    List<String> listeMots = PythonCodeAnalyzer.extraireListeMots(requestBody);

                    // Vérifier si un fichier a été envoyé  précédemment
                    if (uploadedFiles.isEmpty()) {
                        return "Aucun fichier n'a été envoyé précédemment";
                    }

                    // Récupérer le dernier fichier envoyé
                    String dernierFichierEnvoye = uploadedFiles.get(uploadedFiles.size() - 1);

                    // Lire le contenu du fichier
                    String contenu = new String(Files.readAllBytes(Paths.get(dernierFichierEnvoye)));

                    // compter les occurrences des mots dans le contenu du fichier
                    Map<String, Integer> occurrences = PythonCodeAnalyzer.occurrencesMots(contenu, listeMots);

                    // Convertir le résutat en JSON (avec jackson)
                    String json = PythonCodeAnalyzer.convertirEnJson(occurrences);

                    return json;

                }
            } catch (IOException e) {
                LOGGER.warning("Erreur lors de la lecture du corps de la requête : " + e.getMessage());
            }
            return null;
        }


        /**
         * Vérifie si le corps de la requête est un fichier ou une liste de mots
         * @param requestBody
         * @return
         */
        private boolean isFileRequest(String requestBody) {
            // vérifier si le corps de la requête correspond à un fichier ou à une liste de mots
            if (requestBody.startsWith("mots=")) {
                return false;   // C'est une liste de mots
            } else {
                return true;    // C'est un fichier
            }
        }

        /** 
         * Générer une réponse HTML simple à partir d'un paramètre de requête
         * @param httpExchange : 
         * @param requestParamVaue : 
         */
        private void handleResponse(HttpExchange httpExchange, String requestParamValue)  throws  IOException {
            OutputStream outputStream = httpExchange.getResponseBody();

            // Envoi de la réponse au client 
            String json = requestParamValue;

            // Spécifier le contenu de la réponse et envoyer les en-têtes HTTP
            httpExchange.getResponseHeaders().set("Content-Type", "application/json");
            httpExchange.getResponseHeaders().add("Access-Control-Allow-Origin", "*");
            httpExchange.getResponseHeaders().add("Access-Control-Allow-Methods", "POST");
            httpExchange.getResponseHeaders().add("Access-Control-Allow-Headers", "Content-Type");
            // this line is a must
            httpExchange.sendResponseHeaders(200, json.length());
            outputStream.write(json.getBytes());
            outputStream.flush();
            outputStream.close();
        }

        // Interface method to be implemented
        @Override
        public void handle(HttpExchange httpExchange) throws IOException {
            LOGGER.info("Réponse à la requête");
            String requestParamValue=null;
            if("GET".equals(httpExchange.getRequestMethod())) {
                LOGGER.info("Méthode GET");
                requestParamValue = handleGetRequest(httpExchange);
            }
            else if ("POST".equals(httpExchange.getRequestMethod())) {
                // Gérer la requête POST (faire la même chose que pour la méthode get mais avec la méthode post)
                LOGGER.info("Méthode POST");
                requestParamValue = handlePostRequest(httpExchange);
            }
            else {
                LOGGER.warning("Méthode non gérée");
            }
            handleResponse(httpExchange,requestParamValue);

        }
    }
}