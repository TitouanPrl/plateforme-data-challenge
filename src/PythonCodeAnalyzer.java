



import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.io.File;

// Importation de la librairie jackson
import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.ObjectMapper;

// importation du hashmap
import java.util.HashMap;
import java.util.Map;


public class PythonCodeAnalyzer {

    


    public static void main(String[] args) {

        File folder = new File("py");
        List<String> listeFichier = listeFichierDuDossier(folder, ".py");

        for (String fichier : listeFichier) {
            System.out.println(fichier);
            String pythonFilePath = "py/" + fichier;
            List<FunctionData> functionDataList = analyzePythonCode(pythonFilePath);
            System.out.println("###############################################################");
            printFunctionStatistics(functionDataList);
            
        }


        // test de jackson pour convertir un objet en json
        ObjectMapper mapper = new ObjectMapper();
        Map<String, String> map = new HashMap<>();
        map.put("name", "John");
        map.put("age", "30");
        String json = "";
        try {
            json = mapper.writeValueAsString(map);
        } catch (JsonProcessingException e) {
            e.printStackTrace();
        }
        System.out.println(json);
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
     * Enlève les lignes vides d'un fichier python
     * @param filePath : chemin du fichier python
     * @return lines : liste de lignes non vides
     */
    public static List<String> enleverLignesVides(String filePath) {
        List<String> lines = new ArrayList<>();
        BufferedReader reader = null;

        try {
            reader = new BufferedReader(new FileReader(filePath));
            String line;

            while ((line = reader.readLine()) != null) {
                line = line.strip();

                if (!line.isEmpty()) {
                    lines.add(line);
                }
            }

            return lines;
        } catch (IOException e) {
            e.printStackTrace();
        } finally {
            // fermeture du reader
            if (reader != null) {
                try {
                    reader.close();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
        }
        // si on arrive ici, c'est qu'il y a eu une erreur
        return null;
    }

    /**
     * Enlève tous les commentaires d'un fichier python (il faut que les paramètres des fonctions soient sur une seule ligne)
     * @param filePath : chemin du fichier python
     * @return lines : liste de lignes sans commentaires
     */
    public static List<String> enleverCommentaires(String filePath) {
        List<String> lines = new ArrayList<>();
        BufferedReader reader = null;

        try {
            reader = new BufferedReader(new FileReader(filePath));
            String line;

            while ((line = reader.readLine()) != null) {
                line = line.strip();

                // enlever les commentaires en ligne
                if (!line.isEmpty() && !line.startsWith("#")) {
                    lines.add(line);
                } 
                // enlever les commentaires en bloc
                else if (line.startsWith("'''")) {
                    while (!line.endsWith("'''")) {
                        line = reader.readLine();
                    }
                }
            }

            return lines;
        } catch (IOException e) {
            e.printStackTrace();
        } finally {
            // fermeture du reader
            if (reader != null) {
                try {
                    reader.close();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
        }
        // si on arrive ici, c'est qu'il y a eu une erreur
        return null;
    }



    /**
     * Analyse le code python et retourne une liste de données sur les fonctions
     * @param filePath : chemin du fichier python
     * @return functionDataList : liste de données sur les fonctions
     */
    public static List<FunctionData> analyzePythonCode(String filePath) {
        List<FunctionData> functionDataList = new ArrayList<>();
        BufferedReader reader = null;

        try {
            reader = new BufferedReader(new FileReader(filePath));
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
                    }


                    // Commencer les données de la nouvelle fonction
                    currentFunctionName = line.substring(4, line.indexOf("("));
                    currentFunctionLines = 0;
                } else if (line.startsWith("#")) {
                    line = reader.readLine();
                } else if (line.startsWith("'''")) {
                    while (!line.endsWith("'''")) {
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

        return functionDataList;
    }

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


        // Statistiques de chaque fonction
        for (FunctionData functionData : functionDataList) {
            System.out.println("Fonction : " + functionData.getFunctionName());
            System.out.println("Nombre de lignes : " + functionData.getLines());
            System.out.println("---------------------------");
        }

        System.out.println("Nombre de fonctions : " + numberOfFunctions);



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
    }
}
