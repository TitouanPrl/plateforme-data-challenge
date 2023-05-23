import java.io.*;

public class Nombres {
	
	
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
	
	public static String supprimerTriplesQuotes(String texte) {
		String[] lignes = texte.split("\\r?\\n");
	    StringBuilder sb = new StringBuilder();
	    boolean state;
	    state = false;
	    
	    for (String ligne : lignes) {
	    	if (ligne.trim().startsWith("\"\"\"")) {
	    		if (ligne.trim().endsWith("\"\"\"") && ligne.trim().indexOf("\"\"\"",3) != -1) {
	    			sb.append("\n");
	    		}
	    		else if (ligne.trim().indexOf("\"\"\"",3) != -1) {
	    			sb.append(ligne).append("\n");;
	    		}
	    		else {
	    			sb.append("\n");
	    			if (state == true) {
	    				state = false;
	    			}
	    			else {
	    				state = true;
	    			}
	    		}
	    	}
	    	else if (ligne.trim().contains("\"\"\"")) {
	    		if (state == true) {
	    			state = false;
	    			int indexg = ligne.trim().indexOf("\"\"\"");
	    			if (ligne.trim().indexOf("\"\"\"",indexg+1) != -1) {
	    				sb.append("\n");
	    			}
	    			else {
	    				sb.append(ligne).append("\n");
	    			}
	    		}
	    		else {
	    			state = true;
	    			sb.append(ligne).append("\n");	
	    		}
	    	}
	    	else {
	    		if (state == true) {
	    			sb.append("\n");
	    		}
	    		else {
		    		sb.append(ligne).append("\n");	    			
	    		}
	    	}
	    }
	    return sb.toString();
	}
	
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
	
	public static String supprimerCommentaires(String texte) {
		String texteG = supprimerTriplesQuotes(texte);
		String texteS = supprimerHastags(texteG);
		texteS = supprimerLignesVides(texteS);
		return texteS;
	}
	
	public static int nbLignes(String texte) {
		String[] lignes = texte.split("\\r?\\n");
		int nbl = 0;
		for (String ligne : lignes) {
			nbl += 1;
		}
		return nbl;
	}
	
	public static int nbFonction(String texte) {
		String[] lignes = texte.split("\\r?\\n");
		int nbf = 0;
		String tabulation = "";
		boolean dansf = false;
		for (String ligne : lignes) {
			if (ligne.trim().startsWith("def") && dansf == false) {
				dansf = true;
				nbf += 1;
				tabulation += "";
			}
			else if (dansf == true) {
				if (ligne.trim().startsWith(tabulation)) {
					dansf = false;
					tabulation = "";
				}
				else {
					nbf += 1 ;
					if (ligne.trim().startsWith("\t")) {
						tabulation += "";
					}
				}
			}
		}		
		return nbf;
	}
	
	public static void Fonctions(String texte) {
		String[] lignes = texte.split("\\r?\\n");
		int min = -1;
		int max = -1;
		int somme = 0;
		int nbl = 0;
		String tabulation = "";
		boolean dansf = false;
		for (String ligne : lignes) {
			if (ligne.trim().startsWith("def")) {
				dansf = true;
				tabulation += " ";
			}
			else if (dansf == true) {
				nbl += 1;
				if (!ligne.trim().startsWith(tabulation)) {
					dansf= false;
					tabulation = "";
					somme += nbl;
					if (min == -1) {
						min = nbl;
					}
					if (max == -1) {
						max = nbl;
					}
					if (nbl > max) {
						max = nbl;
					}
					if (nbl < min) {
						min = nbl;
					}
					nbl = 0;
				}
			}
			int moy = somme/nbFonction(texte);
			System.out.println("le nombre minimum de lignes des fonctions est : " + min);
			System.out.println("le nombre maximum de lignes des fonction est :" + max);
			System.out.println(" le nombre moyen de lignes des fonctions est : " + moy);
		}	
	}	

	public static void main(String[] args) throws IOException {
		String chemin = "/home/cytech/Desktop/AnalysePY2JSON/Fichiers/python/fichier_python.txt";
		String texte=txtToString(chemin);
		texte = supprimerCommentaires(texte);
		
		System.out.println("nombre de fonctions : " + nbFonction(texte));
		System.out.println("nombre de lignes : " + nbLignes(texte));
	}
}
