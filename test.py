def main(string_1, string_2):
    for i in range(len(string_2) - len(string_1) + 1):
        for j in range(len(string_1)):
            if string_2[i + j] != string_1[j]:
                break
            if j == len(string_1) - 1:
                return True
    
    return False

print(main('b', 'ab'), 'b' in 'ab')