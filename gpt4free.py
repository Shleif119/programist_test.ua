import asyncio
from asyncio import WindowsSelectorEventLoopPolicy
from g4f.client import Client
import sys
import io

# Установка политики цикла событий
asyncio.set_event_loop_policy(WindowsSelectorEventLoopPolicy())

# Убедитесь, что стандартный ввод и вывод работают с UTF-8
sys.stdin = io.TextIOWrapper(sys.stdin.buffer, encoding='utf-8')
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')


# Чтение данных из стандартного ввода
file_content = sys.stdin.read()

# Создание клиента и отправка запроса
client = Client()
response = client.chat.completions.create(
    model="gpt-3.5-turbo",
    messages=[{"role": "user", "content": file_content}],
)

# Получение содержимого ответа
response_content = str(response.choices[0].message.content)  # Преобразование в строку


# Печать для проверки (опционально)
print(response_content)
