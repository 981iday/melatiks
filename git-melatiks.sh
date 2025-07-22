#!/bin/bash
echo "==== Git Commands for Melatiks ===="
echo "1. git status"
echo "2. git add ."
echo "3. git add <file>"
echo "4. git commit -m \"pesan\""
echo "5. git push origin master"
echo "6. git pull origin master"
echo "7. git checkout -b <branch>"
echo "8. git checkout <branch>"
echo "9. git checkout master && git merge <branch>"
echo "10. git checkout -- <file>"
echo "11. git log --oneline"
echo "==================================="

read -p "Pilih nomor perintah (1-11): " cmd

case $cmd in
  1) git status ;;
  2) git add . ;;
  3) read -p "Masukkan nama file: " file; git add "$file" ;;
  4) read -p "Masukkan pesan commit: " msg; git commit -m "$msg" ;;
  5) git push origin master ;;
  6) git pull origin master ;;
  7) read -p "Masukkan nama branch baru: " branch; git checkout -b "$branch" ;;
  8) read -p "Masukkan nama branch: " branch; git checkout "$branch" ;;
  9) read -p "Masukkan nama branch yang mau di-merge ke master: " branch; git checkout master && git merge "$branch" ;;
  10) read -p "Masukkan nama file: " file; git checkout -- "$file" ;;
  11) git log --oneline ;;
  *) echo "Pilihan tidak valid" ;;
esac
