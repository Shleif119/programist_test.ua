import sys
import io

# Встановлення потрібного кодування
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')

# Основний код програми
z= int(input()) 
s= int(input()) 

u = (z + s)/ 2


print(f"Середнє арифметичне чисел {z} і {s} дорівнює {u} ")
