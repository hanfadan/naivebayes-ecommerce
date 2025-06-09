# convert_snap.py
import ast, json

INPUT = 'meta_Clothing_Shoes_and_Jewelry.json'
OUTPUT = 'meta_valid.jsonl'

with open(INPUT, 'r', encoding='utf-8') as fin, open(OUTPUT, 'w', encoding='utf-8') as fout:
    for line in fin:
        line = line.strip()
        if not line:
            continue
        try:
            # parse Python literal → dict
            obj = ast.literal_eval(line)
            # dump as proper JSON
            fout.write(json.dumps(obj, ensure_ascii=False) + '\n')
        except Exception:
            # skip baris yang error
            continue

print(f"Wrote valid JSONL to {OUTPUT}")
