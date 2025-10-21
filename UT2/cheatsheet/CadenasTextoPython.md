# 🐍 Chuleta de Cadenas de Texto en Python

## 🔤 Concepto básico
Cadenas (strings) = secuencias de caracteres Unicode (incluye emojis 😎).
Ejemplos: 'Hola', "Mundo"

## 🧱 Crear strings

Simples: 'texto'

Dobles: "texto"

Triples (multilínea / docstrings): """texto""" (PEP 257 recomienda dobles triples)

## 🚫 Cadena vacía
''

## 🔄 Conversión de tipos
str(10) → '10' · int('10') → 10 · float('3.14') → 3.14

## 🧩 Secuencias de escape
| Secuencia | Significado |
|---|---|
| \n | salto de línea |
| \t | tabulación |
| \' | comilla simple |
| \\ | barra invertida |

## 🧱 Raw strings
r'a\tb\tc' → muestra literalmente a\tb\tc

## 🖨️ print()
print(a, b, sep='|', end='!!')

## ⌨️ Entrada por teclado
name = input('Tu nombre: ')
⚠️ No llames input a una variable.

## ➕ Operaciones

Concatenar: 'Hola ' + 'Mundo'

Repetir: 'Hi! ' * 3 → Hi! Hi! Hi!

## 🔢 Índices y rebanadas (slicing)
'Python'[0] → 'P' · 'Python'[-1] → 'n' · 'Python'[0:3] → 'Pyt'
(fin exclusivo: llega hasta end - 1)

## 📏 Longitud
len('Hola') → 4

## 🔍 Búsqueda

Contiene: 'sol' in 'girasol' → True

Inicio/fin: texto.startswith('Hola'), texto.endswith('fin')

Primera ocurrencia: texto.find('a') / texto.index('a')

Contar: texto.count('a')

## 🧼 Limpiar texto
strip() (espacios / \n / \t), lstrip(), rstrip()
' x \n'.strip() → 'x' · s.strip(chars) para caracteres concretos

## 🔁 Reemplazar
'Quien mal anda'.replace('mal', 'bien')

## 🔠 Mayúsculas / minúsculas
capitalize() · title() · upper() · lower() · swapcase()

## 🔎 Identificación de caracteres
isalpha() · isdigit() · isalnum() · isupper() · islower() · isnumeric()

## 🧮 Interpolación (f-strings)
f'Me llamo {name} y tengo {age} años'
Formateo: f'{pi:.2f}' · f'{n:05d}' · f'{valor:x}' (hex)
Debug: f'{var=}' → var=...

## 🚀 Unicode
'\N{ROCKET}' → 🚀 · ord('A') → 65 · chr(65) → 'A'

## 🔡 Comparación
Lexicográfica: 'a' < 'b', 'A' < 'a' (mayúsculas antes en Unicode)

## ✅ Resumen rápido

Concatenar: 'a' + 'b'

Repetir: 'a' * 3

Longitud: len(s)

Buscar: 'x' in s

Limpiar: s.strip()

Caso: s.upper(), s.lower()

f-strings: f'{var}'

> Nota: los strings son inmutables (se crean nuevos al modificar).

# ejercicios
```
Password con patrón simple (string, random)
import string
import random

letras = string.ascii_letters
digitos = string.digits
simbolos = "!#$%&*"

a = random.choice(letras)
b = random.choice(letras)
c = random.choice(letras)
d = random.choice(letras)

e = random.choice(digitos)
f = random.choice(digitos)
g = random.choice(digitos)
h = random.choice(digitos)

i = random.choice(simbolos)
j = random.choice(simbolos)

password = a + b + c + d + e + f + g + h + i + j
print("Password generada: ", password)
```
```
print("¿Todos los caracteres son numéricos?", numero.isnumeric())
```
```
print("¿Son iguales?", palabra1 == palabra2)
print(f"¿Es la palabra {palabra1} mayor que la palabra {palabra2}?", palabra1 > palabra2)
```
```
print("Frase en orden inverso:", frase[::-1])
```
```
cadena = ' 192.168.001.010 '.strip()

primer = cadena.find(".")
octeto1fin = cadena[primer+1:]
octeto1 = cadena[:primer]

segundo = octeto1fin.find(".")
octeto2fin = octeto1fin[segundo+1:]
octeto2 = octeto1fin[:segundo]

tercero = octeto2fin.find(".")
octeto3fin = octeto2fin[tercero+1:]
octeto3 = octeto2fin[:tercero]
```
