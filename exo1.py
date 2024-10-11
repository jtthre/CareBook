produit1=float(input('Entrez le prix hors taxe du premier produit'))
produit2=float(input('Entrez le prix hors taxe du second produit'))
produit3=float(input('Entrez le prix hors taxe du troisieme produit'))

qte=int(input('Entrez la qte a acheter du premier produit '))
qte2=int(input('Entrez la qte a acheter du second produit '))
qte3=int(input('Entrez la qte a acheter du troisieme produit '))

prixHorsTAxe= produit1 * qte + produit2*qte2 + produit3*qte3
print('Le prix hors taxe de la course est de ' , prixHorsTAxe)
tva= 0.05

prix= prixHorsTAxe * tva

print('Le prix total est : ', prix)