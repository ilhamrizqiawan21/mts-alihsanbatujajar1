from pathlib import Path
import re

src = Path('C:/laragon/www/mts-alihsan1/mts-alihsan/mts_alihsan (4).sql')
dst = Path('C:/laragon/www/mts-alihsan1/mts-alihsan/mts_alihsan_sanitized.sql')

text = src.read_text(encoding='utf-8-sig')
text = text.replace('`nilai_total`, `keterangan`, `created_at`', '`keterangan`, `created_at`')
text = re.sub(r"(INSERT INTO `kebersihan_kelas` .*? VALUES\s*\([^)]*?,)\s*2(?=\s*,\s*'')", r"\1", text, count=1, flags=re.S)
dst.write_text(text, encoding='utf-8')
print(f'Sanitized SQL written to {dst}')
