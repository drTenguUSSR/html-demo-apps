# Деплой на HelioHost

#  Вытягивание на стороне HelioHost

1. Настройте скрипт на HelioHost:
   после создания клона репозитория будет автоматически создан на johnny скрипт типа
   https://johnny.heliohost.org:8443/modules/git/public/web-hook.php?uuid=333-22-1111
   

    Как узнать адрес:
    - открыть админку
    - Websites & Domains / drtengu341.heliohost.us
    - открыть склонированный репозиторий
    - нажать внизу экрана Repository Setting (рядом с мусорной корзиной)
    - в пункте "webhook URL" будет указан адрес

2. Создайте вебхук GitHub: В настройках репозитория на GitHub (Settings -> Webhooks)
   можно указать ссылку (URL), которую GitHub будет «дергать» при каждом пуше:
   открыть репозиторий/ выбрать Settings/ Code, planning, and automation/ webhooks


    Как заполнить поля формы настройки:
    - Payload URL: Вставьте сюда точный URL-адрес скрипта на вашем HelioHost,
    который будет принимать уведомления от GitHub
    (например, https://johnny.heliohost.org:8443/modules/git/public/web-hook.php?uuid=333-22-111).
    - Content type: выбрать application/json
    - Secret: не используется при штатном хуке
    - SSL verification: Enable SSL verification
    - Which events...: Выберите Just the push event\
    Если всё настроено верно, рядом с созданным вебхуком появится зеленая галочка.
