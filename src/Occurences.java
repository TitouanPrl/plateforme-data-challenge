import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;

public class Occurences {

	public static void main(String[] args) {
		String texte = "\n def hello(): \n\n\t#jesuisuncommentaire\n\t'''commentaire\n\ten\n\tbloc'''\n\tprint(\"Hello World\") '''\tcommentaire\nen\nbloc2\n'''\ndef fonction():\n\treturn 0";
		texte = supprimerCommentaires(texte);
		System.out.println(texte);
	}
	
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
	

}