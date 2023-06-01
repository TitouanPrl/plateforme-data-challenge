



import java.io.BufferedReader;
import java.io.FileReader;
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

        // String code = "\n def hello(): \n\n\t#jesuisuncommentaire\n\t'''commentaire\n\ten\n\tbloc'''\n\tprint(\"Hello World\")\n\tprint(\"testtesttest\") '''\tcommentaire\nen\nbloc2\n'''\ndef fonction():\n\treturn 0";
        // System.out.println(code);
        // code=supprimerCommentaires(code);
        // System.out.println("----------------------\n" + code);   
        // String json = analyzePythonCode(code);

        // System.out.println(json);



        
        String texteExemple = "def fonction1():\n\treturn \"je suis la fonction 1\"\n'''jesuis\nun\ncommentaire\nen\nbloc'''\ndef fonction2():\n\treturn 2";
        System.out.println(texteExemple);
        String mot = "re";
        System.out.println("nb occurences de " + mot +  " : " + nbOccurrences(texteExemple, mot));

    }


    /**
     * Compte le nombre d'occurrences de mots dans un texte 
     * @param texte : texte dans lequel on cherche les occurrences
     * @param mot : mot dont on cherche le nombre d'occurrences
     * @return nbOccurrences : nombre d'occurrences du mot dans le texte
     */
    public static int nbOccurrences(String str, String motif) {
        int count = 0;
        int lastIndex = 0;
        while (lastIndex != -1) {
            lastIndex = str.indexOf(motif, lastIndex);
            if (lastIndex != -1) {
                count++;
                lastIndex += motif.length();
            }
        }
        return count;
    }
    

    
    
    


    /**
     * Fonction qui prend en entrée une liste de mot sous forme de chaîne de caractères et qui retourne une Map avec le nombre d'occurences de chaque mot
     * @param listeMots : liste de mots dont on cherche le nombre d'occurrences
     * @param texte : texte dans lequel on cherche les occurrences
     * @return mapOccurrences : map avec le nombre d'occurrences de chaque mot
     */
    public static Map<String, Integer> occurrencesMots(String texte, List<String> listeMots) {
        Map<String, Integer> mapOccurrences = new HashMap<>();
        for (String mot : listeMots) {
            mapOccurrences.put(mot, nbOccurrences(texte, mot));
        }
        return mapOccurrences;

    }


    /**
     * Extraire les mots de la liste de mots
     * @param requestBody : liste de mots sous forme de chaîne de caractères
     * @return listeMots : liste de mots sous forme de Liste de String
     */
    public static List<String> extraireListeMots(String requestBody) {
        List<String> listeMots = new ArrayList<>();
        String[] mots = requestBody.split(",");
        for (String mot : mots) {
            mot.trim();
            listeMots.add(mot);
        }
        return listeMots;
    }


    
    

    /**
     * Affiche la liste des fichiers du dossier
     * @param folder : répertoire cible
     * @param extension : extension des fichiers souhaitée 
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
        code = supprimerCommentaires(code);
        List<FunctionData> functionDataList = new ArrayList<>();
        BufferedReader reader = null;
        // System.out.println("code de la requête : " + code);
        try {
            reader = new BufferedReader(new StringReader(code));
            String line;
            String currentFunctionName = null;
            int currentFunctionLines = 1;

            while ((line = reader.readLine()) != null) {
                line = line.strip();

                // si la ligne commence par def et se termine par : alors c'est une fonction
                if ((line.startsWith("def")) && (line.endsWith(":"))) {
                    // ajouter la fonction précédente
                    if (currentFunctionName != null) {
                        functionDataList.add(new FunctionData(currentFunctionName, currentFunctionLines));
                        // System.out.println(currentFunctionName + " : " + currentFunctionLines);
                    }

                    // Commencer les données de la nouvelle fonction à ajouter
                    currentFunctionName = line.substring(4, line.indexOf("("));
                    currentFunctionLines = 1;
                } else if (!line.isEmpty()) {
                    currentFunctionLines++;
                }
            }

            // Add les données de la dernière fonciton à la liste
            if (currentFunctionName != null) {
                functionDataList.add(new FunctionData(currentFunctionName, currentFunctionLines));
            }

        } catch (IOException e) {
            e.printStackTrace();
        } finally {

            // Fermeture du reader s'il est ouvert
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
     * Supprimer les lignes vides d'un code python
     * @param texte : code python sous forme de chaîne de caractères
     * @return texte : code python sans les lignes vides
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
     * Supprimer les commentaires d'un code python commençant par #
     * @param texte : code python sous forme de chaîne de caractères
     * @return texte : code python sans les commentaires
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
     * Supprimer les commentaires en bloc délimités par """ et """
     * @param texte : code python sous forme de chaîne de caractères
     * @return texte : code python sans les commentaires
     */
	public static String supprimerQuotes1(String texte) {
		char[] caracteres = texte.toCharArray();
		int index_depart = 0;
		boolean state = false;
		StringBuilder sb = new StringBuilder();
		
		for (int i = index_depart ; i < (texte.length()- 3); i++) {
			if (caracteres[i] == '\"') {
				if (caracteres[i+1] == '\"') {
					if (caracteres[i+2] == '\"') {
						if (state == true) {
							state = false;
							caracteres[i] = ' ';
							caracteres[i+1] = ' ';
							caracteres[i+2] = ' ';
						}
						else {
							state = true;
						}
					}
				}
			}
			if (state == false) {
				sb.append(caracteres[i]);
			}
			if (state == true) {
				if (caracteres[i] == '\n') {
					sb.append('\n');
				}
			}
		}
		sb.append(caracteres[texte.length()-3]);
		sb.append(caracteres[texte.length()-2]);
		sb.append(caracteres[texte.length()-1]);
		return sb.toString();
	}
	


    /**
     * Supprimer les commentaires en bloc délimités par ''' et '''
     * @param texte : code python sous forme de chaîne de caractères
     * @return texte : code python sans les commentaires
     */
	public static String supprimerQuotes2(String texte) {
		char[] caracteres = texte.toCharArray();
		int index_depart = 0;
		boolean state = false;
		StringBuilder sb = new StringBuilder();
		
		for (int i = index_depart ; i < (texte.length()); i++) {
			if (caracteres[i] == '\'') {
				if (caracteres[i+1] == '\'') {
					if (caracteres[i+2] == '\'') {
						if (state == true) {
							state = false;
							caracteres[i] = ' ';
							caracteres[i+1] = ' ';
							caracteres[i+2] = ' ';
						}
						else {
							state = true;
						}
					}
				}
			}
			if (state == false) {
				sb.append(caracteres[i]);
			}
			if (state == true) {
				if (caracteres[i] == '\n') {
					sb.append('\n');
				}
			}
		}
		return sb.toString();
	}
	

	/**
	 * Convertit un fichier texte en String
	 * @param chemin : chemin du fichier texte
	 * @return String du fichier texte
	 */
	public static String txtToString(String chemin) {
        StringBuilder stringBuilder = new StringBuilder();
        String ligne;
        try (BufferedReader br = new BufferedReader(new FileReader(chemin))) {
            while ((ligne = br.readLine()) != null) {
                stringBuilder.append(ligne);
                stringBuilder.append(System.lineSeparator());
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
        return stringBuilder.toString();
    }
	
	
	/**
	 * Supprime les commentaires et les lignes vides d'un code python
	 * @param texte : code python
	 * @return code python sans commentaires et lignes vides
	 */
	public static String supprimerCommentaires(String texte) {
		String texteG = supprimerQuotes1(texte);
		String texteH = supprimerQuotes2(texteG);
		String texteS = supprimerHastags(texteH);
		texteS = supprimerLignesVides(texteS);
		return texteS.strip();
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
        
        // Gestion des cas particuliers
        if (maxLines == Integer.MIN_VALUE) {
            maxLines = 0;
        }
        if (minLines == Integer.MAX_VALUE) {
            minLines = 0;
        }
        // ajout des données statistiques dans la map
        statistiques.put("nbFonctions", numberOfFunctions);
        statistiques.put("nbLignes", totalLines);
        statistiques.put("nbLignesMax", maxLines);
        statistiques.put("nbLignesMin", minLines);
        statistiques.put("nbLignesMoy", averageLines);


        // Map contenant les statistiques de chaque fonction
        Map<String,Integer> fonction = new HashMap<>();
        // Ajout des données de chaque fonction dans la map
        for (FunctionData functionData : functionDataList) {
            fonction.put(functionData.getFunctionName(), functionData.getLines());
        }

        // Ajout de la map des fonctions dans la map des statistiques
        statistiques.put("Fonctions", fonction);
        

        return statistiques;
    }


    /**
     * Convertit la map en chaîne de caractères
     * @param statistiques : map contenant les statistiques sur les fonctions
     * @return json : chaîne de caractères contenant les statistiques sur les fonctions
     */
    public static String convertirEnJson(Map<String, ?> statistiques) {
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
     * Classe statique pour stocker le nom et le nombre de lignes d'une fonction
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

        /**
         * Compare deux fonctions
         * @param obj : fonction à comparer
         * @return boolean : true si les fonctions sont identiques, false sinon
         */
        @Override
        public boolean equals(Object obj) {
            if (obj == null) {
                return false;
            }
            if (!FunctionData.class.isAssignableFrom(obj.getClass())) {
                return false;
            }
            final FunctionData other = (FunctionData) obj;
            if ((this.functionName == null) ? (other.functionName != null) : !this.functionName.equals(other.functionName)) {
                return false;
            }
            if (this.lines != other.lines) {
                return false;
            }
            return true;
        }
    }

    
}
