def factoriel(n):
    if n == 0:
        return 1
    else:
        return n * factoriel(n-1)
def somme(a,
          b,
          c):
    return a + b + c
livre = {
    "titre": "Le seigneur des anneaux",
    "auteur": "J.R.R. Tolkien",
    "annee": 1954,
    "pages": 531,
    "editeur": "Allen & Unwin",
    "prix": 12.5
}


# def a(param1, param2):
#     def b():
#         return param1 + param2
#     return b()



def test():
    def test2():
        def test3():
            """fesfesfesf
            esfesfesfe
            fesfesfes
            """
            
            print("testtesttest") # fesfesf 
            #fesf esf  