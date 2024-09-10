def compress(data):
    encoding = ''
    i = 0

    while i < len(data):
        count = 1
        while i + 1 < len(data) and data[i] == data[i + 1]:
            i += 1
            count += 1
        encoding += str(count) + data[i]
        i += 1

    return encoding

def decompress(data):
    decoding = ''
    i = 0

    while i < len(data):
        count = ''
        while data[i].isdigit():
            count += data[i]
            i += 1
        decoding += data[i] * int(count)
        i += 1

    return decoding

if __name__ == "__main__":
    import sys
    if len(sys.argv) < 3:
        print("Usage: python3 rle.py <compress/decompress> <data>")
        sys.exit(1)

    mode = sys.argv[1]
    data = sys.argv[2]

    if mode == "compress":
        print(compress(data))
    elif mode == "decompress":
        print(decompress(data))
    else:
        print("Invalid mode. Use 'compress' or 'decompress'.")
