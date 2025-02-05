Небольшой парсер платформы YandexMusic для получения информации по трекам и артистам, и дальнейшем их сохранении в БД
Настройки:
  В файле YandexMusicParser.php идет коннект с БД через класс DBConnect. Чтобы использовать свою БД, вам нужно поменять параметры вызова класса: БД адрес, БД пользователь, БД пароль и название схемы. В моем случае - пароль пустой.
Как использовать:
  При помощи WIN + R вызывайте "выполнить" и вводите "cmd" (запускайте командную строку)
  В командной строке через "cd" перемещайтесь в папку с проектом
  Вводите команду в консоль: php YandexMusicParser.php [(https://music.yandex.ru/artist/6284177/tracks)](https://music.yandex.ru/artist/6284177/tracks) (URL использован для примера)
/*************************************************************************************/
Casual parser through YandexMusic platform to save info about tracks and artists.
Settings:
  In YandexMusicParser.php, there is connection to the bd via class DBConnect. There, you should change db adress, db user, db password and schema name. In my case, password is empty.
How to use:
  Press WIN + R and type in "cmd";
  In the console locate yourself to the folder, where the project is;
  type in following command: php YandexMusicParser.php [(https://music.yandex.ru/artist/6284177/tracks)](https://music.yandex.ru/artist/6284177/tracks) (this link is used as an example)
