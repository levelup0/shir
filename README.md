# Процесс развертывания проекта
- Мы должны перейти в корень проекта

<code>
  cd /home/nginx/ 
</code>

- Далее запуска для создание сборки:

<code>
docker-compose run --rm npm run prod
</code>
<br/>
<code>
docker-compose up -d для запуска
</code>

- Для того чтобы запускать 
npm run prod
в корень:
<code>
docker-compose run --rm npm install
</code>

<code>
docker-compose run --rm npm run prod
</code>