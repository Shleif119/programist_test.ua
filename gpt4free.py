import asyncio
from asyncio import WindowsSelectorEventLoopPolicy
from g4f.client import Client
import sys
import io

# Встановлення потрібного кодування
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')
# Установка политики цикла событий
asyncio.set_event_loop_policy(WindowsSelectorEventLoopPolicy())

# Чтение содержимого файла
with open('input.txt', 'r', encoding='utf-8') as file:
    file_content = file.read()

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
