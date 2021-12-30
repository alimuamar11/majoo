Insert 

`INSERT INTO tbl_produk (nama, deskripsi, harga, fk_kategori, gambar)  VALUES ('Lenowo', 'Text Deskripsi', 200000, 2, 'lenove.jpg');` 

 

Update 

`UPDATE tbl_kategori  SET  nama_kategori = 'Laptop' WHERE id_kategori = 1; `

 

Delete 

`DELETE FROM tbl_kategori WHERE id_kategori=1; `

 

Select 

`SELECT id_produk as _id,nama, deskripsi,harga,fk_kategori,id_kategori,nama_kategori FROM tbl_produk  JOIN tbl_kategori ON tbl_kategori.id_kategori=tbl_produk.fk_kategori`

 
`SELECT id_produk FROM tbl_produk WHERE nama = “Cek nama” `