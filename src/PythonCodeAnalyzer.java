



import java.io.BufferedReader;
// import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.io.File;
import java.io.StringReader;

// Importation de la librairie jackson
import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.ObjectMapper;
// import com.sun.org.slf4j.internal.Logger;

// importation du hashmap
import java.util.HashMap;
import java.util.Map;



public class PythonCodeAnalyzer {

    


    public static void main(String[] args) {

        // File folder = new File("py");
        // List<String> listeFichier = listeFichierDuDossier(folder, ".py");

        // for (String fichier : listeFichier) {
        //     System.out.println(fichier);
        //     String pythonFilePath = "py/" + fichier;
        //     List<FunctionData> functionDataList = analyzePythonCode(new FileReader(pythonFilePath).toString());
        //     System.out.println("###############################################################");
        //     printFunctionStatistics(functionDataList);
            
        // }

        // String code = "def ajouter1(a):\n    return a+1\n'''je suis\nun commentaire'''def ajouter2(a):\n    return a+2\n'''je suis\nun autre commentaire'''";

        // String json = analyzePythonCode(code);

        // System.out.println(json);

    }


    
    

    /**
     * Affiche la liste des fichiers du dossier
     * @param folder : répertoire cible
     * @param extension : extension souhaitée des fichiers
     * @return liste des fichiers du dossier qui ont l'extension donnée
     */
    public static List<String> listeFichierDuDossier(final File folder, String extension) {
        List<String> listeFichier = new ArrayList<>();
        for (final File fileEntry : folder.listFiles()) {
            if (fileEntry.isDirectory()) {
                listeFichier.addAll(listeFichierDuDossier(fileEntry, extension));
            } else {
                if (fileEntry.getName().endsWith(extension)) {
                    listeFichier.add(fileEntry.getName());
                }
            }
        }
        return listeFichier;
        
    }




  
   

    

    /**
     * Analyse le code python et retourne une liste de données sur les fonctions
     * @param code : Fichier python sous forme de chaîne de caractères 
     * @return functionDataList : liste de données sur les fonctions
     */
    public static String analyzePythonCode(String code) {
        List<FunctionData> functionDataList = new ArrayList<>();
        BufferedReader reader = null;
        System.out.println("code de la requête : " + code);
        try {
            reader = new BufferedReader(new StringReader(code));
            String line;
            String currentFunctionName = null;
            int currentFunctionLines = 1;
            // boolean estDansCommentaire = false;

            while ((line = reader.readLine()) != null) {
                line = line.strip();

                if ((line.startsWith("def")) && (line.endsWith(":"))) {

                    
                    // ajouter la fonction précédente
                    if (currentFunctionName != null) {
                        functionDataList.add(new FunctionData(currentFunctionName, currentFunctionLines));
                        System.out.println(currentFunctionName + " : " + currentFunctionLines);
                    }


                    // Commencer les données de la nouvelle fonction
                    currentFunctionName = line.substring(4, line.indexOf("("));
                    currentFunctionLines = 1;
                } else if (line.startsWith("#")) {
                    line = reader.readLine();
                } else if (line.startsWith("'''")) {
                    while (!line.endsWith("'''")) {
                        line = reader.readLine();
                    }
                } else if (line.startsWith("\"\"\"")) {
                    while (!line.endsWith("\"\"\"")) {
                        line = reader.readLine();
                    }
                }
                else if (!line.isEmpty()) {
                    currentFunctionLines++;
                }
            }

            // Add data for the last function
            if (currentFunctionName != null) {
                functionDataList.add(new FunctionData(currentFunctionName, currentFunctionLines));
            }
            // Afficher les données sur les fonctions
            // for (FunctionData functionData : functionDataList) {
            //     // System.out.println(functionData);
            // }
        } catch (IOException e) {
            e.printStackTrace();
        } finally {
            if (reader != null) {
                try {
                    reader.close();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
        }

        // Conversion de la liste de fonctions en données sur les fonctions
        Map<String, Object> statistiques = convertirEnMap(functionDataList);

        // Conversion de la map en chaîne de caractères
        String statistiquesEnJson = convertirEnJson(statistiques);

        return statistiquesEnJson;
        
    }




/**
 * Supprime les lignes vides
 * @param texte : texte à analyser
 * @return texte sans les lignes vides
 */
    public static String supprimerLignesVides(String texte) {
	    String[] lignes = texte.split("\\r?\\n");
	    StringBuilder sb = new StringBuilder();
	    for (String ligne : lignes) {
	        if (!ligne.trim().isEmpty()) {
	            sb.append(ligne).append("\n");
	        }
	    }
	    return sb.toString();
	}
	


    /**
     * Supprime les lignes de commentaires commençant par #
     * @param texte : texte à analyser
     * @return texte sans les lignes de commentaires
     */
	public static String supprimerHastags(String texte) {
		String[] lignes = texte.split("\\r?\\n");
	    StringBuilder sb = new StringBuilder();
	    for (String ligne : lignes) {
	        if (!ligne.trim().startsWith("#")) {
	            sb.append(ligne).append("\n");
	        }
	    }
	    return sb.toString();
	}



    /**
     * Convertit la liste de données sur les fonctions en une map
     * @param functionDataList : liste de données sur les fonctions
     * @return statistiques : map contenant les statistiques sur les fonctions
     */
    public static Map<String, Object> convertirEnMap(List<FunctionData> functionDataList) {
        Map<String, Object> statistiques = new HashMap<>();
        int totalLines = 0;
        int maxLines = Integer.MIN_VALUE;
        int minLines = Integer.MAX_VALUE;

        for (FunctionData functionData : functionDataList) {
            int lines = functionData.getLines();
            totalLines += lines;
            maxLines = Math.max(maxLines, lines);
            minLines = Math.min(minLines, lines);
        }

        int numberOfFunctions = functionDataList.size();
        double averageLines;
        if (numberOfFunctions == 0) {
            System.out.println("Aucune fonction trouvée");
            averageLines = 0;

        } else {
            averageLines = (double) totalLines / numberOfFunctions;
        }
        
        if (maxLines == Integer.MAX_VALUE) {
            maxLines = 0;
        }
        if (minLines == Integer.MIN_VALUE) {
            minLines = 0;
        }
        // ajout des données statistiques dans la map
        statistiques.put("nbFonctions", numberOfFunctions);
        statistiques.put("nbLignes", totalLines);
        statistiques.put("nbLignesMax", maxLines);
        statistiques.put("nbLignesMin", minLines);
        statistiques.put("nbLignesMoy", averageLines);


        Map<String,Integer> fonction = new HashMap<>();
        // Statistiques de chaque fonction
        for (FunctionData functionData : functionDataList) {
            fonction.put(functionData.getFunctionName(), functionData.getLines());
        }

        statistiques.put("Fonctions", fonction);
        

        return statistiques;
    }


    /**
     * Convertit la map en chaîne de caractères
     * @param statistiques : map contenant les statistiques sur les fonctions
     * @return json : chaîne de caractères contenant les statistiques sur les fonctions
     */
    public static String convertirEnJson(Map<String, Object> statistiques) {
        // Conversion en json avec jackson
        ObjectMapper mapper = new ObjectMapper();
        String json = "";

        try {
            json = mapper.writeValueAsString(statistiques);   
        } catch (JsonProcessingException e) {
            e.printStackTrace();
            return null;
        }
        return json;
    }
        


    /**
     * Affiche les statistiques sur les fonctions
     * @param functionDataList : liste de données sur les fonctions
     */
    public static void printFunctionStatistics(List<FunctionData> functionDataList) {
        int totalLines = 0;
        int maxLines = Integer.MIN_VALUE;
        int minLines = Integer.MAX_VALUE;

        for (FunctionData functionData : functionDataList) {
            int lines = functionData.getLines();
            totalLines += lines;
            maxLines = Math.max(maxLines, lines);
            minLines = Math.min(minLines, lines);
        }

        int numberOfFunctions = functionDataList.size();
        double averageLines;
        if (numberOfFunctions == 0) {
            System.out.println("Aucune fonction trouvée");
            averageLines = 0;

        } else {
            averageLines = (double) totalLines / numberOfFunctions;
        }
        
        Map<String, Object> statistiques = new HashMap<>();


        // Statistiques générales des fichiers python
        System.out.println("Nombre de fonctions : " + numberOfFunctions);
        System.out.println("Nombre total de lignes : " + totalLines);
        if (maxLines == Integer.MAX_VALUE) {
            maxLines = 0;
        }
        if (minLines == Integer.MIN_VALUE) {
            minLines = 0;
        }
        System.out.println("Nombre maximum de lignes par fonction : " + maxLines);
        System.out.println("Nombre minimum de lignes par fonction : " + minLines);
        System.out.println("Nombre moyen de lignes par fonction :  " + averageLines);
        System.out.println("---------------------------\nStatistiques par fonction :\n---------------------------");


        // ajout des données statistiques dans la map
        statistiques.put("nbFonctions", numberOfFunctions);
        statistiques.put("nbLignes", totalLines);
        statistiques.put("nbLignesMax", maxLines);
        statistiques.put("nbLignesMin", minLines);
        statistiques.put("nbLignesMoy", averageLines);


        Map<String,Integer> fonction = new HashMap<>();
        // Statistiques de chaque fonction
        for (FunctionData functionData : functionDataList) {
            System.out.println("Fonction : " + functionData.getFunctionName());
            System.out.println("Nombre de lignes : " + functionData.getLines());
            System.out.println("---------------------------");
            fonction.put(functionData.getFunctionName(), functionData.getLines());
            // statistiques.put("Fonctions",functionData);
        }

        statistiques.put("Fonctions", fonction);
        // Conversion en json avec jackson
        ObjectMapper mapper = new ObjectMapper();
        String json = "";

        try {
            json = mapper.writeValueAsString(statistiques);
            System.out.println(json);   
        } catch (JsonProcessingException e) {
            e.printStackTrace();
        }
        



    }

    
    /**
     * Classe pour stocker le nom et le nombre de lignes d'une fonction
     */
    static class FunctionData {
        private String functionName;
        private int lines;


        /**
         * Constructeur
         * @param functionName : nom de la fonction
         * @param lines : nombre de lignes de la fonction
         */
        public FunctionData(String functionName, int lines) {
            this.functionName = functionName;
            this.lines = lines;
        }


        /**
         * Getters
         * @return functionName : nom de la fonction
         */
        public String getFunctionName() {
            return functionName;
        }


        /**
         * Getters
         * @return lines : nombre de lignes de la fonction
         */
        public int getLines() {
            return lines;
        }

        /**
         * Affiche les données de la fonction
         * @return String : chaîne de caractères contenant les données de la fonction
         */
        @Override
        public String toString() {
            return "FunctionData [functionName=" + functionName + ", lines=" + lines + "]";
        }
    }

    
}
