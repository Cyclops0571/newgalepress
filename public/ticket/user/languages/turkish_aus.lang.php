<?php
namespace sts;


class lang {

	private $lang_array = array();

	function __construct() {
	
		$language_array['Add'] 									= 'Ekle';
		$language_array['Edit'] 								= 'Düzenle';
		$language_array['Save'] 								= 'Kaydet';
		$language_array['Cancel'] 								= 'İptal';
		$language_array['Delete'] 								= 'Sil';
		
		$language_array['Yes'] 									= 'Onay';
		$language_array['No'] 									= 'Red';
		$language_array['On'] 									= 'Açık';
		$language_array['Off'] 									= 'Kapalı';

		$language_array['Guest Portal'] 						= 'Misafir Portalı';
		$language_array['Tickets'] 								= 'Biletler';
		$language_array['Login'] 								= 'Giriş';
		$language_array['Logout'] 								= 'Çıkış';
		$language_array['Home'] 								= 'Ana Sayfa';
		$language_array['Welcome'] 								= 'Hoş Geldiniz';
		$language_array['Profile'] 								= 'Profil';
		$language_array['Users'] 								= 'Kullanıcılar';
		$language_array['User'] 								= 'Kullanıcı';
		$language_array['Settings'] 							= 'Ayarlar';
		$language_array['Email'] 								= 'Email';
		$language_array['Register'] 							= 'Kayıt';

		$language_array['Name'] 								= 'İsim';
		$language_array['Username'] 							= 'Kullanıcı Adı';
		$language_array['Password'] 							= 'Şifre';
		$language_array['Password Again'] 						= 'Şifre Tekrar';

		$language_array['Forgot Password'] 						= 'Şifremi Unuttum';
		$language_array['Create Account'] 						= 'Kullanıcı Oluştur';
		$language_array['Login Failed'] 						= 'Giriş Başarısız';
		
		$language_array['Departments'] 							= 'Departmanlar';
		$language_array['Priorities'] 							= 'Öncelikler';
		$language_array['AD'] 									= 'AD';
		$language_array['Plugins'] 								= 'Eklentiler';
		$language_array['View Log'] 							= 'Logları Görüntüle';
		$language_array['Log'] 									= 'Log';
		$language_array['Logs'] 								= 'Logs';
		$language_array['All login attempts are logged.']		= 'Bütün giriş denemeleri loglandı.';
		
		$language_array['You must have an account before you can submit a ticket. Please register here.'] = 
		'Bilet yollamak için hesabınız olmalı. Buradan kayıt olabilirsiniz.';
		
		$language_array['Account Registration Is Disabled.']	= 'Kullanıcı kaydı pasif.';

		$language_array['Ticket']								= 'Bilet';
		$language_array['Edit Ticket']							= 'Bileti Düzenle';
		$language_array['View Ticket']							= 'Bileti Görüntüle';

		$language_array['Gravatar']								= 'Gravatar';

		$language_array['Change Password']						= 'Şifre Değiştir';
		$language_array['Current Password']						= 'Mevcut Şifre';

		$language_array['Email Notifications']					= 'Email Bildirimleri';

		$language_array['New Password']							= 'Yeni Şifre';
		$language_array['New Password Again']					= 'Yeni Şifre Tekrar';

		$language_array['Profile Updated']						= 'Profil Güncellendi';

		$language_array['New Ticket']							= 'Yeni Bilet';
		$language_array['Permissions']							= 'İzinler';

		$language_array['Status']								= 'Statüler';
		$language_array['Priority']								= 'Öncelik';
		$language_array['Submitted By']							= 'Tarafından Gönderildi';
		$language_array['Assigned User']						= 'Görevli Kullanıcı';
		$language_array['Department']							= 'Departman';
		$language_array['Added']								= 'Eklendi';
		$language_array['Updated']								= 'Güncellendi';
		$language_array['ID']									= 'ID';

		$language_array['User Details']							= 'Kullanıcı Bilgileri';
		$language_array['Phone']								= 'Telefon';
		$language_array['Files']								= 'Belgeler';

		$language_array['Notes']								= 'Notlar';
		$language_array['Add Note']								= 'Not Ekle';
		$language_array['Attach File']							= 'Dosya Ekle';
		$language_array['Close Ticket']							= 'Bileti Kapat';
		
		$language_array['ago']									= 'önce';

		$language_array['Open']									= 'Açık';
		$language_array['Closed']								= 'Kapalı';

		$language_array['Search']								= 'Arama';
		$language_array['Sort By']								= 'Sıralama';
		$language_array['Sort Order']							= 'Sıralama Düzeni';
		$language_array['Assigned']								= 'Görevli';

		$language_array['Ascending']							= 'Artan';
		$language_array['Descending']							= 'Azalan';

		$language_array['Close']								= 'Kapat';
		$language_array['Filter']								= 'Filtrele';
		$language_array['Clear']								= 'Temizle';
		
		$language_array['Failed To Create Account']				= 'Kullanıcı kaydı başarısız';
		$language_array['Passwords Do Not Match']				= 'Şifreler uyuşmuyor';
		$language_array['Username Invalid']						= 'Kullanıcı Adı Hatalı';
		$language_array['Email Address In Use']					= 'Email Adresi Kullanılıyor';
		$language_array['Email Address Invalid']				= 'Email Adresi Hatalı';
		$language_array['Please Enter A Name']					= 'Lütfen İsminizi Giriniz';
		$language_array['Account Registration Is Disabled.']	= 'Üye kaydı pasif.';
		$language_array['Create a Support Ticket']				= 'Destek Bileti Oluştur';
		$language_array['Page Limit']							= 'Sayfa Limiti';
		
		$language_array['The database needs upgrading before you continue.']	= 'Devam etmeden önce veritabanını güncelleyiniz.';
		
		$language_array['Upgrade']								= 'Güncelleme';
		$language_array['Open Tickets']							= 'Açık Biletler';
		$language_array['Copyright']							= 'Telif Hakkı';
		$language_array['This ticket is from a user without an account.'] = 'Bu bilet kullanıcısı olmayan bir kişiye aittir..';

		$language_array['Subject']								= 'Konu';
		$language_array['Description']							= 'Açıklama';
		$language_array['Subject Empty']						= 'Konu Yok';
		$language_array['File Upload Failed. Ticket Not Submitted.']						= 'Dosya güncellemesi başarısız. Bilet gönderilemedi.';

		$language_array['Description']							= 'Açıklama';
		$language_array['IP Address']							= 'IP Adresi';
		$language_array['This page displays the last 100 events in the system.']	= 'Bu sayfada son 100 olay gösterilmektedir.';
		
		$language_array['Show All']								= 'Hepsini Göster';

		$language_array['Item']									= 'Madde';
		$language_array['Value']								= 'Değer';

		$language_array['Severity']								= 'Önem Derecesi';
		$language_array['Type']									= 'Tür';
		$language_array['Source']								= 'Kaynak';
		$language_array['User ID']								= 'Kullanıcı IDsi';
		$language_array['Reverse DNS Entry']					= 'DNS Girişini Tersine Çevir';
		$language_array['File']									= 'Dosya';
		$language_array['File Line']							= 'Dosya Hattı';
		
		$language_array['Are you sure you wish to delete this ticket?']							= 'Bu bileti silmek istediğinize emin misiniz?';
		
		$language_array['Selected Tickets']						= 'Seçili Biletler';
		$language_array['No Tickets Found.']					= 'Bilet Bulunamadı.';

		$language_array['Previous']								= 'Geri';
		$language_array['Next']									= 'İleri';
		$language_array['Page']									= 'Sayfa';

		$language_array['Toggle']								= 'Anahtar';
		$language_array['Do']									= 'Yap';
		$language_array['New Guest Ticket']						= 'Yeni Misafir Bileti';

		$language_array['Address']								= 'Adres';
		$language_array['Authentication Type']					= 'Bilgi Doğrulama';


		$language_array['Program Version']						= 'Program Versyonu';
		$language_array['Database Version']						= 'Database Versyonu';

		$language_array['There is a software update available.'] = 'Güncelleme bulunamadı.';

		$language_array['More Information']						= 'Daha Fazla Bilgi';
		$language_array['Settings Saved']						= 'Ayarlar Kaydedildi';
		$language_array['Site Settings']						= 'Site Ayarları';

		$language_array['View Guest Ticket']					= 'Misafir Biletini Görüntüle';
		$language_array['Unable to reset password.']			= 'Şifre yenilenemiyor.';
		$language_array['An email with a reset link has been sent to your account.']			= 'Şifre yenilemesi için gereken link kullanıcıya yollandı.';
		
		$language_array['Request Reset']						= 'Yenileme İste';

		$language_array['If you have forgotten your password you can reset it here.'] = 'Şifrenizi unuttuysanız buradan yenileyebilirsiniz..';
		$language_array['An email will be sent to your account with a reset password link. Please follow this link to complete the password reset process.'] = 'Şifre yenileme linkiniz mail adresinize yollanmıştır. Linki kullanalar yenileme işleminizi tamamlayabilirsiniz.';

		$language_array['Update Info']							= 'Bilgileri Güncelle';
		$language_array['Update Information']					= 'Bilgileri Güncelle';
		$language_array['Installed Version']					= 'Mevcut Versiyon';
		$language_array['Available Version']					= 'Güncellenebilir Versiyon';
		
		$language_array['Download']								= 'İndir';
		$language_array['No updates found.']					= 'Güncelleme bulunamadı.';


		$language_array['Submitter']							= 'Sunucu';
		$language_array['Administrator']						= 'Admin';
		$language_array['Plus User']							= 'Ayrıcalıklı Üye';
		$language_array['Moderator']							= 'Moderatör';

		$language_array['Edit User']							= 'Kullanıcı Düzenle';		
		$language_array['View User']							= 'Kullanıcı Görüntüle';

		$language_array['Local']								= 'Yerel';
		$language_array['Active Directory']						= 'Aktif Kütüphane';
		
		$language_array['Add User']								= 'Kullanıcı Ekle';
		$language_array['New User']								= 'Yeni Kullanıcı';
		
		$language_array['Full Name']							= 'Tam Ad';
		
		$language_array['Email (recommended)']					= 'Email (gerekli)';
		$language_array['Phone (optional)']						= 'Telefon (isteğe bağlı)';
		$language_array['Address (optional)']					= 'Adres (isteğe bağlı)';

		$language_array['Name Empty']							= 'İsim Alanı Boş';
		$language_array['Username Empty']						= 'Kullanıcı Adı Alanı Boş';
		$language_array['Password Empty']						= 'Şifre Alanı Boş';
		$language_array['Username In Use']						= 'Kullanıcı Adı Kullanılıyor';

		$language_array['Passwords Do Not Match']				= 'Şifreler Uyuşmuyor';
		$language_array['Password (if blank the password is not changed)']				= 'Şifre (boş ise şifre değişmez)';

		$language_array['Version']								= 'Versyon';
		$language_array['Disabled']								= 'Pasif';
		$language_array['Enabled']								= 'Aktif';

		$language_array['This page upgrades the database to the latest version.'] = 'Bu sayfada veritabanı son veriyonuna güncellenir.';

		$language_array['Your database is currently up to date and does not need upgrading.'] = 'Veritabanı güncel.';

		$language_array['Upgrade Complete.']					= 'Güncelleme Tamamlandı.';

		$language_array['Please ensure you have a full database backup before continuing.']	= 'Devam etmeden önce veritabanını yedeklediğinizden emin olunuz.';
	
		$language_array['Start Upgrade']						= 'Güncellemeyi Başlat';
		$language_array['Site Name']							= 'Site Adı';
		$language_array['Domain Name (e.g example.com)']		= 'Alan Adı (e.g example.com)';
		$language_array['Script Path (e.g /sts)']				= 'Script Path (e.g /sts)';
	
		$language_array['Port Number (80 for HTTP and 443 for Secure HTTP are the norm)']				= 'Port Numarası (HTTP için 80, güvenli HTTP için 443 olmalı)';

		$language_array['Secure HTTP (recommended, requires SSL certificate)']		= 'Güvenli HTTP (önerilen, SSL sertifikası gereklidir)';

		$language_array['Default Language']						= 'Varsayılan Dil';
		$language_array['Site Options']							= 'Site Seçenekleri';
		$language_array['HTML & WYSIWYG Editor']				= 'HTML & WYSIWYG Editörü';
		$language_array['Account Protection (user accounts are locked for 15 minutes after 5 failed logins)']	= 'Kullanıcı Güvenliği (5 hatalı giriş sonrası kullanıcı 15 dakika boyunca kitlenir)';
		
		$language_array['Login Message']						= 'Giriş Mesajı';
		$language_array['Account Registration Enabled']			= 'Üye Kaydı Aktif';

		$language_array['Gravatar Enabled']						= 'Gravatar Aktif';
		$language_array['File Storage Enabled (for file attachments)']	= 'Dosya Depolaması Aktif (ek dosyalar için)';

		$language_array['File Storage Path (must be outside the public web folder e.g./home/sts/files/ or C:\sts\files\)']						= 'Dosyanın Saklandığı Yer (Açık web dosyasının dışında olmalı, /home/sts/files/ veya C:\sts\files\)';

		$language_array['Ticket Settings']						= 'Bilet Özellikleri';
		$language_array['Ticket Settings Saved']				= 'Bilet Özellikleri Kaydedildi';
		
		$language_array['Are you sure you wish to delete this user?'] = 'Bu kullanıcıyı silmek istediğinize emin misiniz?';

		$language_array['General Settings']						= 'Genel Ayarlar';
		$language_array['Reply/Notifications for Anonymous Tickets (sends emails to non-users)'] = 'Anonim Kullanıcılar için Yanıtlar/Bildirimler(üye olmayanlara mail atılması)';

		$language_array['Guest Portal Text']					= 'Misafir Portalı Yazısı';
		
		$language_array['Please note that removing priorities that are in use will leave tickets without a priority.']					= 'Kullanılan öncelikleri kaldırmak biletleri önceliksiz bırakacaktır.';

		$language_array['Please note that removing departments that are in use will leave tickets without a department.']				= 'Kullanılan departmanları kaldırmak biletleri departmansız bırakacaktır.';

		$language_array['Default Department cannot be deleted.']				= 'Varsayılan departman silinemeaz.';

		$language_array['You cannot delete yourself.']							= 'Kendinizi silemezsiniz.';
		
		$language_array['Note: LDAP is required for this function to work.']	= 'Not: LDAP bu fonksiyonun çalışması için gereklidir.';

		$language_array['Server (e.g. dc.example.local or 192.168.1.1)']		= 'Server (e.g. dc.example.local or 192.168.1.1)';
		$language_array['Account Suffix (e.g. @example.local)']					= 'Account Suffix (e.g. @example.local)';
		$language_array['Base DN (e.g. DC=example,DC=local)']					= 'Base DN (e.g. DC=example,DC=local)';
		$language_array['Create user on valid login']							= 'Geçerli Girişte Kullanıcı Oluştur';

		$language_array['Plugins can be used to add extra functionality to Tickets.']							= 'Biletlerinize ekstra fonksiyon eklemek için eklentileri kullanabilirsiniz.';
		$language_array['Please ensure that you only install trusted plugins.']							= 'Sadece doğru eklentiyi yüklediğinizden emin olunuz.';

		$language_array['Email Settings']										= 'Email Ayarları';
		$language_array['Cron has been run.']									= 'Cron çalışıyor.';

		$language_array['Please ensure that you have the cron system setup, otherwise emails will not be sent or downloaded.'] = 'Cron sisteminin yüklediğine emin olunuz, aksi takdire emailler gönderilemez ve indirilemez.';

		$language_array['Run Cron Manually']									= 'Cron\'u elle çalıltır';
		$language_array['Test Email']											= 'Test Emaili';
		$language_array['Email Address']										= 'Email Adresi';
		$language_array['Send Test']											= 'Testi Yolla';

		$language_array['Outbound SMTP Server']									= 'Outbound SMTP Server';
		$language_array['SMTP Enabled']											= 'SMTP Aktif';
		$language_array['Server']												= 'Server';
		$language_array['Port']													= 'Port';
		$language_array['TLS']													= 'TLS';
		$language_array['Outgoing Email Address']								= 'Giden Email Adresi';
		$language_array['SMTP Authentication']									= 'SMTP Doğrulaması';

		$language_array['POP3 Accounts']										= 'POP3 Hesapları';
		$language_array['Hostname']												= 'Host İsmi';

		$language_array['Email Notification Templates']							= 'Email Bildieim Taslakları';
		$language_array['Body']													= 'Body';
		$language_array['New Ticket Note']										= 'Yeni Bilet Notu';
	

		$language_array['Add POP Account']										= 'POP Hesabı Ekleme';
		$language_array['Add Account']											= 'Hesap Ekle';
		$language_array['Edit Account']											= 'Hesabı Düzenle';

		$language_array['No POP3 Accounts Are Setup.']							= 'POP3 Hesapları Yüklenmedi.';

		$language_array['Name (nickname for this account)']						= 'İsim (hesap için kullanıcı adı)';
		$language_array['Hostname (i.e mail.example.com)']						= 'Host İsmi (örneğin mail.example.com)';
		$language_array['TLS (required for gmail and other servers that use SSL)']	= 'TLS (gmail ve diğer SSL kullanan servisler için gerekli)';
		
		$language_array['Port (default 110)']									= 'Port (varsayılan 110)';
	
		$language_array['Download File Attachments']							= 'Ekteki Dosyaları İndir';
		$language_array['Leave Message on Server']								= 'Servera Mesaj Bırak';

		$language_array['Adding a POP account allows the system to download emails from the POP account and convert them into Tickets.'] = 'POP eklemek sistemin mailinizden POP hesabını indirmenizi ve onu bilete çevirmenizi sağlar.';
		$language_array['The system will match email address to existing users and attach emails to ticket notes if the email is part of an existing ticket.'] = 'Sistem mailinizi kayıtlı kullanıcı ile eşleştirecektir ve eğer mail biletin bir parçası ise maili bilet notlarına ekleyecektir.';
		$language_array['The Department and Priority options are only used when creating a new ticket and not when attaching an email to an existing ticket.']								= 'Departman ve öncelik özellikleri sadece yeni bir bilet oluşturulurken kullanılır ve mevcut bilete mail eklenirken kullanılamaz.';

		$language_array['Are you sure you wish to delete this POP3 Account?']	= 'POP3 Hesabını silmek istediğinizden emin misiniz?';

		$language_array['Test Email Failed. View the logs for more details.']	= 'Email testi başarısız. Detaylar için loglara bakınız.';
		$language_array['Test Email Failed. Email address was empty.']			= 'Email testi başarısız. Adres kutucuğu boş.';
		$language_array['Test Email Failed. SMTP server not set.']				= 'Email testi başarısız. SMTP server belirlenmemiş.';

		$language_array['Error']												= 'Hata';

		$language_array['Captcha']												= 'Güvenlik Kodu';
		$language_array['Anti-Spam Image']										= 'Anti-Spam Resim';
		$language_array['Anti-Spam Text']										= 'Anti-Spam Metin';
		$language_array['Anti-Spam Text Incorrect']								= 'Anti-Spam Metin Yanlış';
		$language_array['Anti-Spam Captcha Enabled (helps protect the guest portal and user registration from bots)']	= 'Anti-Spam Koruması Aktif (misafir portalını ve üye kaydı alanını botlara karşı korur)';

		$language_array['If email address is present notifications can be emailed to the user.'] = 'Mail adresi belirlenmişse bildirimler kullanıcıya mail yolu ile iletir.';
		$language_array['Local: The password is stored in the local database.']	= 'Lokal: Şifre lokal veritabanında saklanır.';
		$language_array['Active Directory: The password is stored in Active Directory, password fields are ignored.'] = 'Aktif Kütüphane: Şifre Aktif Kütüphanede saklanır, şifre alanları kaldırılmıştır.';
		$language_array['Note: Active Directory must be enabled and connected to an Active Directory server in the settings page.'] = 'Not: Kütüphanenin aktif olması sağlanmalı ve ayarlar sayfasından sunucuya bağlanmalı.';
		$language_array['Submitters: Can create and view their own tickets.'] = 'Gönderici: Bilet oluşturup, biletlerini görüntüleyebilir.';   
		$language_array['Users: Can create and view their own tickets and view assigned tickets.'] = 'Kullanıcı: Bilet oluşturup, biletlerini ve atandığı biletleri görüntüleyebilir.';
		$language_array['Moderators: Can create and view all tickets, assign tickets and create tickets for other users.'] = 'Moderatör: Bilet oluşturabilir, bütün biletleri görüntüler ve diğer kullanıcılar için bilet oluşturabilir.';
		$language_array['Administrators: The same as Moderators but can add users and change System Settings.'] = 'Admin: Moderatöre ek olarak kullanıcı ekleyebilir ve sistem ayarlarını değiştirebilir.';

		$language_array['You cannot change the password for this account.']		= 'Bu hesabın şifresini değiştiremezsiniz..';

		$language_array['Private Message']										= 'Özel Mesaj';
		$language_array['Private Messages']										= 'Özel Mesajlar';
		$language_array['To']													= 'Kime';
		$language_array['From']													= 'Kimden';
		$language_array['Date']													= 'Tarih';
		$language_array['Unread']												= 'Okunmamış';
		$language_array['Sent']													= 'Yollandı';
		
		$language_array['Are you sure you wish to delete this message?']		= 'Mesajı silmek istediğinize emin misiniz?';

		$language_array['View Message']											= 'Mesajı Görüntüle';
		$language_array['Create Message']										= 'Mesaj Yolla';
		$language_array['Send']													= 'Yolla';

		$language_array['Notice']												= 'Bildirim';
		$language_array['Warning']												= 'Hata';
		$language_array['Authentication']										= 'Doğrulama';
		$language_array['Cron']													= 'Cron';
		$language_array['POP3']													= 'POP3';
		$language_array['Storage']												= 'Depolama';
		$language_array['No Messages']											= 'Mesaj Yok';
		
		
		//Version 2.1+
		
		$language_array['Custom Fields']										= 'Özel Alanlar';
		$language_array['Text Input']											= 'Metin Girişi';
		$language_array['Text Area']											= 'Metin Alanı';
		$language_array['Drop Down']											= 'Açılan Menü';
		$language_array['Dropdown']												= 'Aşağı Açılan';
		$language_array['Dropdown Fields']										= 'Açılır Alan';
		$language_array['Input Type']											= 'Giriş Türü';
		$language_array['Option']												= 'Özellikler';
		$language_array['Input Options']										= 'Giriş Özellikleri';

		$language_array['Custom Fields allow you to add extra global fields to your tickets.']	= 'Özel alanlar sayesinde biletinize ekstra global alanlar ekleyebilirsiniz.';


		$language_array['Text Input (single line of text).']					= 'Metin Girişi (tek satır).';
		$language_array['Text Area (multiple lines of text).']					= 'Metin Alanı (çoklu satır).';
		$language_array['Dropdown box with options.']							= 'Dropdown box with options.';
		$language_array['All data attached to this custom field will be deleted. Are you sure you wish to delete this Custom Field?'] = 'Bu alandaki bütün veriler silinecektir. Silme işlemi gerçekleştirilsin mi?';

		
		//Version 2.2+
		$language_array['Closed Tickets']										= 'Closed Tickets';                
		$language_array['Show Extra Settings']									= 'Ekstra Özellikleri Göster';
		$language_array['Default Timezone']										= 'Varsayılan Saat Dilimi';
		$language_array['Colour']												= 'Renk';
		$language_array['Add Status']											= 'Statü Ekle';
		$language_array['Edit Status']											= 'Statüyü Düzenle';
		$language_array['HEX Colour']											= 'HEX Renk Kodu';
		$language_array['Are you sure you wish to delete this Status?']			= 'Statüyü silmek istediğinize emin misiniz?';

		
		//Vesion 2.3+
		$language_array['External Services']									= 'Dış Serviisler';
		$language_array['Add SMTP Account']										= 'SMTP Hesabı Ekle';
		$language_array['Select SMTP Account']									= 'SMTP Hesabı Seç';
		$language_array['Default SMTP Account']									= 'Varsayılan SMTP Hesabı';
		$language_array['SMTP Accounts']										= 'SMTP Hesapları';
		$language_array['Are you sure you wish to delete this SMTP account?']	= 'SMTP hesabını silmek istediğinize emin misiniz?';
		$language_array['Port (default 25)']									= 'Port (varsayılan 25)';
		$language_array['Pushover Enabled']										= 'Kolaylaştırma Aktif';
		$language_array['Pushover for all Users']								= 'Bütün Kullanıcılar için Kolaylaştırma';
		$language_array['Pushover Application Token']							= 'Kolaylaştırıcı Uygulama Simgesi';
		$language_array['Pushover Key']											= 'Kolaylaştırma Anahtarı';

		$language_array['Notifications']										= 'Bildirimler';

		$language_array['Below is a list of the users who will receive pushover notifications whenever a new ticket or ticket note is added.']		= 'Yeni bilet veya bilet notu oluşturulduğunda bildirim alacak kullanıcıların listesi aşağıdadır.';
		
		$language_array['On Behalf Of']											= 'Adına';                                 
		$language_array['Assigned To']											= 'Atanan';
		
		//Version 2.4+
		$language_array['Global Moderator']										= 'Global Yönetici';
		$language_array['Staff']												= 'Personel';
		$language_array['Public']												= 'Genel';
		$language_array['Members']												= 'Üyeler';
		$language_array['Add Department']										= 'Departman Ekle';
		$language_array['Edit Department']										= 'Departman Düzenle';
		$language_array['Are you sure you wish to delete this Department?']		= 'Departmanı silmek istediğinizden emin misiniz?';
		$language_array['Replies']												= 'Cevaplar';
		$language_array['Reply']												= 'Cevap';

		$language_array['Staff: Can create and view their own tickets, view assigned tickets and view tickets within assigned departments.'] = 'Personel: Bilet oluşturabilir ve onları görüntüleyebilirsiniz, görevli olduğunuz biletleri görebilirsiniz ve seçtiğiniz departmandaki biletleri görebilirsiniz.';
		$language_array['Moderators: Can create and view tickets, assign tickets and create tickets for other users within assigned departments.'] = 'Moderatör: Bilet oluşturabilir, bütün biletleri görüntüleyebilir ve görevli olduğu departmandaki kullanıcılar için bilet oluşturabilir..';
		$language_array['Global Moderators: Can create and view all tickets, assign tickets and create tickets for other users.'] = 'Global Moderatör: Bilet oluşturabilir, bütün biletleri görüntüleyebilir ve başka kullanıcılar için bilet oluşturabilir.';
		$language_array['Administrators: The same as Global Moderators but can add users and change System Settings.'] = '		Admin: Global Moderatöre ek olarak kullanıcı ekleyebilir ve sistem ayarlarını değiştirebilir.';
		
		//Version 2.5+
		$language_array['Email Account']										= 'Mail Hesabı';
		$language_array['Map']													= 'Harita';
		$language_array['Send Welcome Email']									= 'Hoşgeldiniz Maili Gönder';
		$language_array['New User (Welcome Email)']								= 'Yeni Kullanıcı (Hoşgeldiniz Maili)';
		$language_array['Are you sure you wish to clear the queue?']			= 'Sırayı silmek istediğinize emin misiniz?';
		$language_array['Reset Cron']											= 'Cron Sıfırla';
		$language_array['Clear Queue']											= 'Sırayı Temizle';
		
		//Version 3.0+
		$language_array['General']												= 'Genel';
		$language_array['API']													= 'API';
		$language_array['Default Theme']										= 'Varsayılan Tema';
		$language_array['Default Sub Theme']									= 'Varsayılan Alt Tema';
		
		$language_array['API Settings']											= 'API Ayarları';
		$language_array['API Enabled']											= 'API Aktif';
		$language_array['API Accounts']											= 'API Hesapları';
		$language_array['Key']													= 'Anahtar';
		$language_array['Access Level']											= 'Erişim Seviyesi';
		$language_array['API Key']												= 'API Anahtarı';
		$language_array['Guest']												= 'Misafir';

		$language_array['Authentication Settings']								= 'Doğrulama Ayarları';
		$language_array['LDAP']													= 'LDAP';
		$language_array['Base DN (e.g. OU=sydney,DC=example,DC=local)']			= 'Temel DN (e.g. OU=sydney,DC=example,DC=local)';

		$language_array['Profile']												= 'Profile';
		$language_array['Logout']												= 'Çıkış';
		$language_array['Auth']													= 'Yazar';
			
		//Version 3.2+
		$language_array['AppTrack']												= 'Uygulama Yolu';
		$language_array['Dashboard']											= 'Gösterge Paneli';
		$language_array['Applications']											= 'Uygulamalar';
		$language_array['month']												= 'ay';
		$language_array['day']													= 'gün';
		$language_array['hour']													= 'saat';
		$language_array['minute']												= 'dakika';
		$language_array['Transfer to Department']								= 'Departmana Aktar';
		$language_array['An email will be sent to this department.']			= 'Mail seçtiğiniz departmana yollanacaktır.';
		$language_array['Assign User']											= 'Görevli Kullanıcı';
		$language_array['An email will be sent to this person.']				= 'Mail seçtiğiniz kullanıcıya yollanacaktır.';
		$language_array['Last Replier']											= 'Son Cevap';
		$language_array['Change State']											= 'Durumu Değiştir';
		$language_array['Email notifications are not sent when editing a ticket from this page.']	= 'Bu sayfada bilet düzenlenirken bilgilendirme maili atılmaz.';
		$language_array['Allow Login']											= 'Giriş İzni Verildi';
		$language_array['Account Added']										= 'Kullanıcı Eklendi';
		$language_array['Assigned Tickets']										= 'Ayrılmış Biletler';
		$language_array['Email Address (recommended)']							= 'Mail Adresi (önerilen)';
		$language_array['Phone Number (optional)']								= 'Telefon (isteğe bağlı)';
		$language_array['Check for updates']									= 'Güncellemeleri Denetle';
		$language_array['New Ticket Reply']										= 'Yeni Cevap';
		$language_array['New Department Ticket']								= 'Yeni Departman Bileti';
		$language_array['New Department Ticket Reply']							= 'Yeni Departman Cevabı';
		$language_array['Assigned User To Ticket']								= 'Bilete Atanmış Kullanıcı';
		$language_array['Reply/Notifications to ticket owner for new tickets via POP3 download']								= 'POP3 ile indrilen biletler için bilet sahibine bildirim gidecektir.';
		$language_array['Online Plugins Directory']								= 'Çevrimiçi Eklenti Kütüphanesi';
		$language_array['Plugins are located on the web server in the user/plugins/ folder.']								= 'Eklentiler web-serverda user/plugins/ dosyasına yerleştirildi.';
		$language_array['Add API Key']											= 'API Anahtarı Ekle';
		$language_array['Published Version']									= 'Yayımlanan Versiyon';
		$language_array['s']													= '';
		$language_array['Show Filter']											= 'Filtreleri Göster';
		
		//3.5+
		$language_array['Reset']												= 'Reset';
		$language_array['Merge']												= 'Birleştir';
		
		///////////////////////////////////////////////////
		$language_array['Add Ticket'] = 'Bilet Ekle';
		$language_array['Show Open Tickets'] = 'Açık Biletleri Göster';
		$language_array['Show Closed Tickets'] = 'Kapalı Biletleri Göster';
		$language_array['Min Added Date'] = 'Başlangıç Tarihi Giriniz';
		$language_array['Max Added Date'] = 'Bitiş Tarihi Giriniz';
		$language_array['Low'] = 'Düşük';
		$language_array['Medium'] = 'Orta';
		$language_array['High'] = 'Yüksek';
		$language_array['Change Status'] = 'Durumu Değiştir';
		$language_array['Default Department'] = 'Varsayılan Departman';
		$language_array['In Progress'] = 'Üzerinde Çalışılıyor';
		$language_array['Select Ticket (for Mass Action)'] = 'Bilet Seç (Çoklu İşlemler İçin)';
		$language_array['Transfer Ticket'] = 'Bileti Transfer Et';
		$language_array['Display Dashboard'] = 'Gösterilecek Panel';
		$language_array['API Require Secure HTTP'] = 'API için Güvenli HTTP (https) Gerekir';
		$language_array['Permission Groups'] = 'İzin Grupları';
		$language_array['No SMTP Accounts Are Setup.'] = 'Kurulu SMTP Hesabı Bulunamadı.';
		$language_array['Password Reset'] = 'Şifre Yenileme';
		$language_array['Ticket Date Due'] = 'Biletin Son Günü';
		$language_array['Carbon Copy Reply'] = 'Kopyasını Gönder';
		$language_array['Allows you to Carbon Copy this ticket to other users e.g. user@example.com,user2@example.net. Note: CCed users will be able to view the entire ticket thread via the guest portal.'] = 'Biletin bir kopyasını da başka bir kullanıcıya göndermenizi sağlar. örn: user@example.com, user2@example.net Not:Kopya gönderilmiş kullanıcı biletin bütün işlemlerini misafir olarak izleyebilir.';
		$language_array['Allows you to Carbon Copy this reply to other users e.g. user@example.com,user2@example.net.'] = 'Biletin bir kopyasını da başka bir kullanıcıya göndermenizi sağlar. örn: user@example.com, user2@example.net';
		$language_array['Note: If enabled CCed users will be able to view the entire ticket thread via the guest portal (but not via email).'] = 'Not:Kopya gönderilmiş kullanıcı biletin bütün işlemlerini misafir olarak izleyebilir. (Fakat mailden takip edemez.)';
		$language_array['An email will be sent to'] = 'Mail gönderilecek kullanıcı:';
		$language_array['Public Reply'] = 'Herkese gidecek mail cevap.';
		$language_array['Private Reply'] = 'Yanlızca istenilen kişiye gidecek cevap.';
		$language_array['History'] = 'Geçmiş';
		$language_array['Live Chat'] = 'Canlı Destek';
		$language_array['Date Due'] = 'Son Gün';
		$language_array['Min Date'] = 'Bu Tarihten Sonra';
		$language_array['Max Date'] = 'Bu Tarihten Önce';
		$language_array['Start Chat'] = 'Sohbete Başla';
		$language_array['Live Chat Enabled'] = 'Canlı Destek Aktif';
		$language_array['Live Chat Disabled'] = 'Canlı Destek Kapalı';
		$language_array['Active Sessions'] = 'Aktif Oturumlar';
		$language_array['Start Time'] = 'Başlangıç Zamanı';
		$language_array['Finished Time'] = 'Bitiş Zamanı';
		$language_array['Last Guest Message'] = 'Son Mesaj';
		$language_array['Started'] = 'Başlangıç';
		$language_array['Finished'] = 'Bitiş';
		$language_array['Messages'] = 'Mesajlar';
		$language_array['Chat Ended'] = 'Sohbet Bitti';
        $language_array['route_home'] = '/tr/anasayfa';


		
		
		
		$this->lang_array 			= $language_array;
		
	}
	
	public function get() {
		return $this->lang_array;
	}

}	
?>