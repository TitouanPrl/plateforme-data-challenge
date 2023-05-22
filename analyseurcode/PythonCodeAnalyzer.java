package analyseurcode;
import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

public class PythonCodeAnalyzer {

    public static void main(String[] args) {
        String pythonFilePath = "test.py";
        List<FunctionData> functionDataList = analyzePythonCode(pythonFilePath);
        printFunctionStatistics(functionDataList);
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
     * Enlève tous les commentaires d'un fichier python
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


    public static List<FunctionData> analyzePythonCode(String filePath) {
        List<FunctionData> functionDataList = new ArrayList<>();
        BufferedReader reader = null;

        try {
            reader = new BufferedReader(new FileReader(filePath));
            String line;
            String currentFunctionName = null;
            int currentFunctionLines = 0;

            while ((line = reader.readLine()) != null) {
                line = line.strip();

                if (line.startsWith("def ") && line.endsWith(":")) {
                    // Found a new function definition
                    if (currentFunctionName != null) {
                        functionDataList.add(new FunctionData(currentFunctionName, currentFunctionLines));
                    }

                    currentFunctionName = line.substring(4, line.indexOf("(")).strip();
                    currentFunctionLines = 0;
                } else if (!line.isEmpty()) {
                    // Count non-empty lines inside a function
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
        double averageLines = (double) totalLines / numberOfFunctions;

        System.out.println("Nombre de fonctions : " + numberOfFunctions);
        System.out.println("Nombre de lignes total : " + totalLines);
        System.out.println("Nombre maximum de lignes par fonction : " + maxLines);
        System.out.println("Nombre minimum de lignes par fonction : " + minLines);
        System.out.println("Nombre moyen de lignes par fonction :  " + averageLines);


        System.out.println("Statistiques par fonction :");
        for (FunctionData functionData : functionDataList) {
            System.out.println("Fonction : " + functionData.getFunctionName());
            System.out.println("Nombre de lignes : " + functionData.getLines());
            System.out.println("------------------------");
        }

        System.out.println("Nombre de fonctions : " + numberOfFunctions);
        

    }

    static class FunctionData {
        private String functionName;
        private int lines;

        public FunctionData(String functionName, int lines) {
            this.functionName = functionName;
            this.lines = lines;
        }

        public String getFunctionName() {
            return functionName;
        }

        public int getLines() {
            return lines;
        }
    }
}
