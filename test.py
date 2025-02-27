list = []
for i in range(3):
    while True:
        num = input("Enter un nombre: ")
        if num.isdigit():
            list.append(int(num))  # Convert to integer before appending
            break  # Exit the while loop when valid number is entered
        else:
            print("Vous n'avez pas entré un nombre valide. Veuillez réessayer.")

print("Le nombre maximal est:", max(list))
print("Le nombre minimal est:", min(list))
