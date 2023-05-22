import java.io.*;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;

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
	    		System.out.println("ligne commence par les guillemets dont le state est :" + state);
	    		if (ligne.trim().endsWith("\"\"\"") && ligne.trim().indexOf("\"\"\"",3) != -1) {
	    			sb.append("\n");
	    		}
	    		else if (ligne.trim().indexOf("\"\"\"",3) != -1) {
	    			sb.append(ligne).append("\n");;
	    		}
	    		else {
	    			sb.append("\n");
	    			System.out.println();
	    			state = true;
	    		}
	    	}
	    	else if (ligne.trim().contains("\"\"\"")) {
	    		System.out.println("ligne contient des guillemets mais ne commence pas par ceux ci dont le state est : " + state );
	    		if (state = true) {
	    			state = false;
	    			if (ligne.trim().endsWith("\"\"\"")) {
	    				sb.append("\n");
	    			}
	    			else {
	    				state = true;
	    				sb.append(ligne).append("\n");;
	    			}
	    		}
	    		else {
	    			sb.append(ligne);	
	    		}
	    	}
	    	else {
	    		System.out.println("ligne sans commentaires dont le state est : " + state);
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
		String texteS = supprimerHastags(texte);
		texteS = supprimerLignesVides(texteS);
		return texteS;
	}
	
	public static void main(String[] args) throws IOException {
		String chemin = "Fichiers/python/fichier_python.txt";
		String texte=txtToString(chemin);

	    System.out.println(supprimerTriplesQuotes(texte));
	    //System.out.println(supprimerCommentaires(texte));
	}
}